<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
        margin: 0;
        padding: 20px;
    }

    .sidebar {
        width: 250px;
        background-color: #343a40;
        color: white;
        height: 100vh;
        padding: 20px;
        position: fixed;
        top: 0;
        left: 0;
    }

    .sidebar h2 {
        color: #ffffff;
        font-size: 1.5em;
        margin-bottom: 20px;
    }

    .sidebar a {
        display: flex; /* Use flexbox for alignment */
        align-items: center; /* Center icons and text vertically */
        color: #ffffff;
        padding: 10px;
        text-decoration: none;
        border-radius: 4px;
        transition: background-color 0.3s;
        margin-bottom: 10px;
    }

    .sidebar a:hover {
        background-color: #007bff;
    }

    .sidebar a i {
        margin-right: 10px; /* Add space between the icon and the text */
    }

    .content {
        margin-left: 270px; /* Adjust to fit sidebar */
        padding: 20px;
    }
</style>

<div class="sidebar">
    <h2>Admin Dashboard</h2>
    <a href="{{ route('admins.allUsers') }}"><i class="fas fa-users"></i> All Users</a>
    <a href="/seller-request/create"><i class="fas fa-user-plus"></i> Become A Seller</a>
    <a href="{{ route('products.new_product') }}"><i class="fas fa-plus"></i> Add New Product</a>
    <a href="{{ route('products.all') }}"><i class="fas fa-box"></i> All Products</a>
    <a href="/admins/orders"><i class="fas fa-list"></i> All Orders</a>
    <a href="/admins/allRequest"><i class="fas fa-envelope"></i> All Requests</a>
    <a href="/products/create"><i class="fas fa-cog"></i> Settings</a>
    
    <form method="POST" action="/logout">
        @csrf
        @method('DELETE')
        <button><i class="fas fa-sign-out-alt"></i> Log Out</button>
    </form>
</div>

