<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Tracking;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function create(Request $request, Order $order)
    {
        $request->validate([
            'tracking_number' => 'required|unique:trackings',
            'carrier' => 'required|string',
            'status' => 'required|string',
        ]);

        Tracking::create([
            'order_id' => $order->id,
            'tracking_number' => $request->tracking_number,
            'carrier' => $request->carrier,
            'status' => $request->status,
        ]);

        return redirect()->route('orders.show', $order)->with('success', 'Tracking information added successfully!');
    }

    public function show(Order $order)
    {
        return view('tracking.show', compact('order'));
    }


     public function index()
    {
        return view('tracking.index');
    }

    public function track(Request $request)
    {
        $request->validate([
            'tracking_number' => 'required|string',
        ]);

        // Retrieve tracking information based on the tracking number
        $tracking = Tracking::where('tracking_number', $request->tracking_number)->first();

        if (!$tracking) {
            return redirect()->back()->with('error', 'Tracking number not found.');
        }

        return view('tracking.show', compact('tracking'));
    }
}

