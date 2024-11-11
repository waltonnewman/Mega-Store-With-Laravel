@extends('layouts.admin_layout')

@section('content')
<style>
    .container {
        margin-top: 20px;
    }
    .card {
        border: 1px solid #007bff;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .card-header {
        background-color: #007bff;
        color: white;
        font-weight: bold;
    }
    .card-body {
        background-color: #f8f9fa;
    }
    .card-title {
        margin-top: 20px;
        color: #343a40;
    }
    .list-group-item {
        background-color: #e9ecef;
        border: none;
    }
    .list-group-item:hover {
        background-color: #d3d3d3;
    }
    .btn-primary {
        background-color: #007bff;
        border: none;
    }
    .btn-primary:hover {
        background-color: #0056b3;
    }
    .alert {
        margin-top: 20px;
    }
</style>

<div class="container">
    <h2>Order Details</h2>

    <div class="card">
        <div class="card-header">
            Order ID: {{ $order->id }}
        </div>
        <div class="card-body">
            <h5 class="card-title">Customer Information</h5>
            <p><strong>Name:</strong> {{ $order->name }}</p>
            <p><strong>Email:</strong> {{ $order->email }}</p>
            <p><strong>Address:</strong> {{ $order->address }}</p>
            <p><strong>City:</strong> {{ $order->city }}</p>
            <p><strong>Total Amount:</strong> ${{ number_format($order->total, 2) }}</p>
            <p><strong>Payment Method:</strong> {{ $order->payment_method }}</p>
            <p><strong>Status:</strong> {{ $order->status }}</p>

            <h5 class="card-title">Order Items</h5>
            <ul class="list-group">
                @foreach($order->items as $item)
                    <li class="list-group-item">
                        {{ $item->product_name }} - Quantity: {{ $item->quantity }} - Price: ${{ number_format($item->price, 2) }}
                    </li>
                @endforeach
            </ul>

            <h5 class="card-title mt-4">Update Order Status</h5>
            <form action="{{ route('orders.updateStatus', $order) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="status">Select Status:</label>
                    <select name="status" id="status" class="form-control">
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Processing" {{ $order->status == 'Processing' ? 'selected' : '' }}>Processing</option>
                        <option value="Transit" {{ $order->status == 'Transit' ? 'selected' : '' }}>Transit</option>
                        <option value="On route" {{ $order->status == 'On route' ? 'selected' : '' }}>On route</option>
                        <option value="Completed" {{ $order->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary mt-2">Update Status</button>
            </form>

            @if(session('success'))
                <div class="alert alert-success mt-3">
                    {{ session('success') }}
                </div>
            @endif
        </div>
    </div>


    <h5 class="card-title mt-4">Add Tracking Information</h5>
<form action="{{ route('tracking.create', $order) }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="tracking_number">Tracking Number:</label>
        <input type="text" name="tracking_number" id="tracking_number" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="carrier">Carrier:</label>
        <input type="text" name="carrier" id="carrier" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="status">Status:</label>
        <input type="text" name="status" id="status" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary mt-2">Add Tracking</button>
</form>
</div>
@endsection
