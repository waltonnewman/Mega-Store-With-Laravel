<?php

namespace App\Http\Controllers;

use App\Models\SellerRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerRequestController extends Controller
{
    public function create()
    {
        return view('seller_requests.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'business_name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        SellerRequest::create([
            'user_id' => Auth::id(),
            'business_name' => $request->business_name,
            'description' => $request->description,
        ]);

        return redirect('/users/dashboard')->with('success', 'Your request to become a seller has been submitted.');
    }

public function dashboard()
{
   

    // Get the current user's latest request status
    $requestStatus = auth()->user() ? auth()->user()->latestRequestStatus() : null;

    return view('/users/dashboard', compact('requestStatus')); // Correct
}




public function allRequest()
    {
        // Fetch orders for the authenticated user
        $allrequests = SellerRequest::paginate(6);

        return view('/admins/allRequest', compact('allrequests'));
    }


     public function destroy(SellerRequest $seller_request)
    {
        $seller_request->delete();
        return redirect()->route('admins.seller_requests')->with('success', 'Product deleted successfully!');
    }

    public function updateRequest(Request $request, SellerRequest $seller_request)
{
    // Validate the incoming request data
    $request->validate([
        'status' => 'required|in:pending,approved,'
    ]);

    // Update the order status
    $seller_request->update(['status' => $request->status]);

    // Redirect back with a success message
    return redirect()->route('admins.allRequest')->with('success', 'Request status updated successfully!');
}

public function showRequest(SellerRequest $seller_request)
{
    return view('admins.view_request', compact('seller_request'));
}


}

