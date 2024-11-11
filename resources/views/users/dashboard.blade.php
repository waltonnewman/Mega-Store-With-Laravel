
@extends('layouts.admin_layout')
@section('content')


     <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }

        .dashboard-header {
            background-color: #007bff;
            color: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
        }

        .welcome-message {
            margin-top: 20px;
            font-size: 1.5em;
            text-align: center;
            color: #333;
        }

        .card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 20px 0;
        }

        .card-title {
            font-size: 1.2em;
            margin-bottom: 10px;
            color: #007bff;
        }

        .card-content {
            color: #555;
        }

        .action-buttons {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .btn {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 10px 20px;
            text-decoration: none;
            margin: 0 10px;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }

        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }
    </style>

   
    @include('includes.user_sidebar', ['requestStatus' => $requestStatus]) <!-- Pass the variable here -->

    <h1>Welcome to the Admin Dashboard</h1>
    <div class="dashboard-header">
        <h1>Welcome to Your Dashboard!</h1>
        <p>We're glad to have you here.</p>
    </div>

    <div class="welcome-message">
        <p style="color: black;">Hello, {{ auth()->user()->name }}! Here are some quick links to get you started:</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-title">Getting Started</div>
        <div class="card-content">
            <p>Explore the features available to you:</p>
            <ul>
                <li>Manage your profile</li>
                <li>View your products</li>
                <li>Check out our resources</li>
            </ul>
        </div>
    </div>

    <div class="action-buttons">
        <a href="#" class="btn">Edit Profile</a>
        <a href="{{ route('products.all') }}" class="btn">View Products</a>
        <a href="#" class="btn">Resources</a>
        <a href="/seller.request.create" class="btn">Become a Seller</a> <!-- New Button -->
    </div>
@endsection
