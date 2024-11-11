<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class CartController extends BaseController
{
    public function index()
    {
        $cart = $this->getCart(); // Get the cart data
        return view('cart.index', compact('cart'));
    }

    public function add(Request $request)
    {

        $cart = $this->getCart();

        // Retrieve the item data
        $item = [
            'id' => $request->input('id'), //product ID
            'variant_id' => $request->input('variant_id'), // Use variant ID instead of product ID
            'quantity' => $request->input('quantity', 1), // Default quantity to 1
            'price' => $request->input('price'), // Price should be included in the form
            'name' => $request->input('name'), // Product title should be included in the form
            'attributes' => $request->input('attributes', []), // Any attributes for variable products
        ];

        // Check if the item is already in the cart
        $found = false;
        foreach ($cart as $cartItem) {
            if ($cartItem['id'] === $item['id'] && $cartItem['variant_id'] === $item['variant_id'] && $cartItem['attributes'] === $item['attributes']) {
                $cartItem['quantity'] += $item['quantity'];
                $found = true;
                break;
            }
        }

        // If not found, add the new item
        if (!$found) {
            $cart[] = $item;
        }

        // Store the updated cart in cookies
        $response = redirect('/shop')->withCookie(cookie('cart', json_encode($cart), 60));

        // Flash success message and link to view the cart
        $response->with('success', 'Item added to cart!')->with('cartLink', route('mycart'));

        return $response;
    }

    public function update(Request $request)
    {
        $cart = $this->getCart();
        $itemId = $request->input('id');
        $newQuantity = $request->input('quantity');

        // Update item quantity in the cart
        foreach ($cart as &$cartItem) {
            if ($cartItem['id'] === $itemId) {
                if ($newQuantity > 0) {
                    $cartItem['quantity'] = $newQuantity;
                } else {
                    // If quantity is 0, remove item instead
                    $cart = array_filter($cart, function ($item) use ($itemId) {
                        return $item['id'] !== $itemId;
                    });
                }
                break;
            }
        }

        // Store the updated cart in cookies
        return response()->json(['success' => true])->withCookie(cookie('cart', json_encode(array_values($cart)), 60));
    }

    public function remove(Request $request)
    {
        $cart = $this->getCart();
        $itemId = $request->input('id');

        // Log the current cart for debugging
        \Log::info('Current cart before removal:', $cart);

        // Remove item from the cart
        $cart = array_filter($cart, function ($cartItem) use ($itemId) {
            return $cartItem['id'] !== $itemId;
        });

        // Log the cart after the removal attempt
        \Log::info('Cart after removal:', $cart);

        // Store the updated cart in cookies
        return response()->json(['success' => true])->withCookie(cookie('cart', json_encode(array_values($cart)), 60));
    }

    protected function getCart() // Change visibility to protected
    {
        $cart = Cookie::get('cart');
        return $cart ? json_decode($cart, true) : [];
    }
}
