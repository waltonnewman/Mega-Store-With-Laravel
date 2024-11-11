@extends('layouts.admin_layout')
@section('content')

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }

        x-page-heading {
            font-size: 2em;
            margin-bottom: 20px;
            color: #333;
        }

        .table-responsive {
            margin-top: 20px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
        }

        .table th, .table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }

        .table th {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }

        .table tr:hover {
            background-color: #f1f1f1;
        }

        .badge {
            margin-right: 5px;
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
            opacity: 0.9;
        }

        .pagination {
            justify-content: center;
            margin-top: 20px;
        }
    </style>

    @include('includes.sidebar')

    <x-page-heading>All Users</x-page-heading>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th> <!-- New column for user -->
                     <th>Role</th> 
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td style="color: black;">{{ $user->id }}</td>
                    <td style="color: black;">{{ $user->name }}</td>
                    <td style="color: black;">{{ $user->email }}</td> <!-- Display user name -->
                    <td style="color: black;">{{ $user->role }}</td> <!-- Display user name -->
                    <td style="color: black;">{{ $user->created_at }}</td> <!-- Display user name -->
                    <td>
                        <a href="" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('products.edit', $user->id) }}" class="btn btn-warning btn-sm">Update</a>
                        <form action="{{ route('admins.destroy', $user->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this user account?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    
@endsection
