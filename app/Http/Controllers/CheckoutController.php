<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order; 
use Illuminate\Support\Facades\Auth;
use App\Models\OrderItem; // Make sure to include the OrderItem model
use App\Models\SellerRequest;
use App\Models\Tracking;
use App\Models\Product;
use App\Mail\OrderConfirmation;
use App\Mail\OrderNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
   public function index()
{
    // Assuming you have a method to retrieve the cart items
    $cart = session()->get('cart', []);
    $grandTotal = 0;

    foreach ($cart as $item) {
        $grandTotal += $item['price'] * $item['quantity'];
    }

    return view('checkout.index', compact('cart', 'grandTotal'));
}

  public function success(Request $request)
{
    $orderId = $request->query('order'); // Get the order ID from the query parameters
    $order = Order::findOrFail($orderId); // Fetch the order from the database

    return view('checkout.success', compact('order')); // Pass the order to the view
}

public function store(Request $request)
{
    // Validate the incoming request data
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'address' => 'required|string|max:255',
        'city' => 'required|string|max:255',
        'payment_method' => 'required', 
      'total' => 'required|string', // Accept as string initially 
    ]); 

     // Retrieve cart items from cookies
    $cartItems = json_decode($request->cookie('cart'), true) ?? [];

    foreach ($cartItems as $item) {
        $pdtdid = $item['id'];
    }

    // Check if the cart is empty
    if (empty($cartItems)) {
        return redirect()->route('checkout.index')->with('error', 'Your cart is empty!');
    }

    // Calculate the total amount
    $submittedTotal = str_replace(',', '', $request->total); // Remove commas
    $totalAmount = (float)$submittedTotal; // Convert to float
    
  
  // Generate a unique tracking number
    $trackingNumber = strtoupper(uniqid('TRACK-')); // Example: TRACK-5f6e7d8e9a

    // Assuming you have the product ID from the request or context
$productId = $pdtdid; // or however you get the product ID
$product = Product::findOrFail($productId); // Retrieve the product


    // Create a new order
    $order = Order::create([
        'product_id' => $pdtdid,
        'name' => $request->name,
        'email' => $request->email,
        'user_id' => auth()->id(),
        'seller_id' => $product->user_id, // Set the seller ID from the product
        'address' => $request->address,
        'city' => $request->city,
        'payment_method' => $request->payment_method,
        'total' => $totalAmount,
        'tracking_number' => $trackingNumber, // Use the generated tracking number
    ]);

     
    

    // Create tracking details
    Tracking::create([
        'order_id' => $order->id,
        'tracking_number' => $trackingNumber, // Use the generated tracking number
        'carrier' => 'DHL', // Assuming this is passed in the request
        'status' => 'pending',
        'buyer_email' => $request->email,
        'buyer_address' => $request->address,
        'buyer_city' => $request->city,
        'total' => $totalAmount,
        'payment_method' => $request->payment_method,
    ]);

    // Store each item in the order_items table and associate with sellers
    foreach ($cartItems as $item) {
        $orderItem = $order->items()->create([
            'order_id' => $order->id,
             'product_id' => $item['id'], // Access the product ID here
            'product_name' => $item['name'],
            'quantity' => $item['quantity'],
            'price' => $item['price'],
        ]);

 }



// Check for product and seller
$sellerEmail = null;
if ($order->product) {
    $seller = $order->seller; // Get the seller directly from the order
    if ($seller) {
        $sellerEmail = $seller->email; // Safely access email
    } else {
        Log::warning('No seller found for order ID: ' . $order->id);
    }
}

// Send the notification if the seller's email is valid
if ($sellerEmail && filter_var($sellerEmail, FILTER_VALIDATE_EMAIL)) {
    Mail::to($sellerEmail)->send(new OrderNotification($order));
} else {
    Log::warning('Invalid seller email for order ID: ' . $order->id);
}

// After creating the order
Mail::to($request->email)->send(new OrderConfirmation($order));



    // Clear the cart cookie after order is placed
    \Cookie::queue(\Cookie::forget('cart'));

    // Redirect or return a response
    return redirect()->route('checkout.success', ['order' => $order->id]);
}

public function showOrders()
    {
        
        // Fetch orders for the authenticated user with their items
    $orders = Order::with('items')->where('user_id', Auth::id())->paginate(2);
        // Get the current user's latest request status
       $requestStatus = auth()->user() ? auth()->user()->latestRequestStatus() : null;

        return view('users.orders', compact('orders', 'requestStatus'));
    }


    public function allOrders()
    {
        // Fetch orders for the authenticated user
         $orders = Order::with('items')->paginate(3);

        return view('admins/orders', compact('orders'));
    } 


     public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admins.orders')->with('success', 'Product deleted successfully!');
    }

    public function updateStatus(Request $request, Order $order)
{
    // Validate the incoming request data
    $request->validate([
        'status' => 'required|in:pending,Processing,Transit,On route,Completed',
    ]);

    // Update the order status
    $order->update(['status' => $request->status]);

    // Redirect back with a success message
    return redirect()->route('admins.orders')->with('success', 'Order status updated successfully!');
}

public function showOrder(Order $order)
{
    return view('admins.orderView', compact('order'));
}

public function showUserOrder(Order $order)
{
    return view('users.viewOrder', compact('order'));
}

}
