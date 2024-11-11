@extends('layouts.admin_layout')
@section('content')

    <style>
        .orders-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .orders-table th, .orders-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .orders-table th {
            background-color: #007bff;
            color: white;
        }
    </style>

    @include('includes.user_sidebar', ['requestStatus' => $requestStatus]) <!-- Pass the variable here -->

    <div class="container">
        <h1>Your Orders</h1>

        @if($orders->isEmpty())
            <p>You have no orders yet.</p>
        @else
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                        <th>Status</th>
                        <th>Tracking No</th>
                        <th>Order Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        @foreach($order->items as $item) <!-- Loop through items -->
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $item->product_name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>${{ number_format($order->total, 2) }}</td>
                                <td>{{ $order->status }}</td>
                                <td>{{ $order->tracking_number }}</td>
                                <td>{{ $order->created_at->format('Y-m-d') }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination Links -->
            <div class="pagination">
                {{ $orders->links() }} <!-- This will generate pagination links -->
            </div>
        @endif
    </div>

@endsection
