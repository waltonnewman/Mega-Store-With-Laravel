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
        <h1 style="text-align: center; font-size: 24px;">All Requests</h1>

        @if($allrequests->isEmpty())
            <p>No request(s) yet.</p>
        @else
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Business Name</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($allrequests as $allrequest)
                        <tr>
                            <td>{{ $allrequest->user_id }}</td>
                           <td>{{ $allrequest->business_name }}</td>
                            <td>{{ $allrequest->status }}</td>
                            <td>{{ $allrequest->created_at->format('Y-m-d') }}</td>
                              <td>
                                  <a href="{{ route('view_request', $allrequest->id) }}" class="btn btn-info btn-sm">View</a>
                                 
                        <form action="{{ route('admins.allRequest', $allrequest->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this order?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                              </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination Links -->
            <div class="pagination">
                {{ $allrequests->links() }} <!-- This will generate pagination links -->
            </div>
        @endif

    </div>

@endsection
