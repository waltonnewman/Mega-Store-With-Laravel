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


        .btn {
            margin: 0 5px;
            border-radius: 4px;
            padding: 6px 12px;
            text-decoration: none;
        }

        .btn-info {
            background-color: #17a2b8;
            color: white;
        }

        .btn-warning {
            background-color: #ffc107;
            color: black;
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
        }

        .btn:hover {
          
    </style>

    @include('includes.sidebar') <!-- Pass the variable here -->

    <div class="container">
        <h1 style="text-align: center; font-size: 24px;">All Orders</h1>

        @if($orders->isEmpty())
            <p>No orders yet.</p>
        @else
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Title</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                        <th>Status</th>
                        <th>Tracking No</th>
                        <th>Order Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                       @foreach($order->items as $item) 
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $item->product_name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>${{ number_format($order->total, 2) }}</td>
                            <td>{{ $order->status }}</td>
                            <td>{{ $order->tracking_number }}</td>
                            <td>{{ $order->created_at->format('Y-m-d') }}</td>
                              <td>
                                  <a href="{{ route('orders.show', $order->id) }}" class="btn btn-info btn-sm">View</a>
                                 
                        <form action="{{ route('orders.destroy', $order->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this order?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                              </td>
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


        @foreach($orders as $order)
    <div>
        <h4>Order ID: {{ $order->id }}</h4>
        <p>Status: {{ $order->status }}</p>

        <form action="{{ route('orders.updateStatus', $order) }}" method="POST">
            @csrf
            <label for="status">Update Status:</label>
            <select name="status" id="status">
                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="Processing" {{ $order->status == 'Processing' ? 'selected' : '' }}>Processing</option>
                <option value="Transit" {{ $order->status == 'Transit' ? 'selected' : '' }}>Transit</option>
                <option value="On route" {{ $order->status == 'On route' ? 'selected' : '' }}>On route</option>
                <option value="Completed" {{ $order->status == 'Completed' ? 'selected' : '' }}>Completed</option>
            </select>
            <button type="submit">Update Status</button>
        </form>
    </div>
@endforeach

    </div>

@endsection
