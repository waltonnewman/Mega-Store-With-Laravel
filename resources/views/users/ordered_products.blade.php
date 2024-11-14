@extends('layouts.admin_layout')

@section('content')


<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
        margin: 0;
        padding: 20px;
    }

    .container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
        color: #343a40;
        margin-bottom: 20px;
        text-align: center;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th, td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #dee2e6;
    }

    th {
        background-color: #007bff;
        color: white;
    }

    tr:hover {
        background-color: #f1f1f1;
    }

    @media (max-width: 768px) {
        .container {
            padding: 10px;
        }

        h1 {
            font-size: 1.5em;
        }

        th, td {
            padding: 8px;
        }
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


@include('includes.user_sidebar', ['requestStatus' => $requestStatus]) <!-- Pass the variable here -->
<div class="container">
    @if(session('success'))
                <div class="alert alert-success mt-3" style=" background-color: rgba(0, 200, 0, 0.5); align-items: center; color: white; padding: 10px;">
                    {{ session('success') }}
                </div>
            @endif
    <h1>Your Ordered Products</h1>

    @if($products->isEmpty())
        <p>You have no products with orders.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Status</th>
                    <th>Orders Count</th>
                    <th>Tracking Num</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->orders->first()->status }}</td>
                        <td>{{ $product->orders->count() }}</td>
                        <td>
                            @if($product->orders->isNotEmpty())
                                {{ $product->orders->first()->tracking_number }} <!-- Display tracking number of the first order -->
                            @else
                                N/A
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('orders.show', $product->orders->first()->id) }}" class="btn btn-info btn-sm">View</a>
                            <form action="{{ route('orders.destroy', $product->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this order?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

@endsection
