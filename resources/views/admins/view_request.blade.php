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
    <h2>Request Details</h2>

    <div class="card">
        <div class="card-header">
            Request ID: {{ $seller_request->id }}
        </div>
        <div class="card-body">
            <h5 class="card-title">Customer Information</h5>
            <p><strong>Name:</strong> {{ $seller_request->user_id }}</p>
            <p><strong>Business:</strong> {{ $seller_request->business_name }}</p>
            <p><strong>Status:</strong> {{ $seller_request->status }}</p>

            <h5 class="card-title mt-4">Update Request Status</h5>
            <form action="{{ route('allRequest.updateStatus', $seller_request) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="status">Select Status:</label>
                    <select name="status" id="status" class="form-control">
                        <option value="pending" {{ $seller_request->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ $seller_request->status == 'approved' ? 'selected' : '' }}>Approved</option>
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
</div>
@endsection
