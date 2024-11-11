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
        transition: transform 0.3s ease; /* Smooth transition for hiding */
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

    .sidebar a i {
    margin-right: 10px; /* Add space between the icon and the text */
}

    .sidebar a:hover {
        background-color: #007bff;
    }

    .content {
        margin-left: 270px; /* Adjust to fit sidebar */
        padding: 20px;
    }

    .pending-message {
        color: #ffc107; /* Yellow color for warning */
        margin-bottom: 10px;
    }

    /* Media Query to hide sidebar on smaller screens */
    @media (max-width: 768px) {
        .sidebar {
            transform: translateX(-100%); /* Move sidebar off-screen */
        }

        .content {
            margin-left: 0; /* Reset margin for content */
        }
    }
</style>

<div class="sidebar">
    <h2>Menu</h2>
    <a href="/users/dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
    <a href="/shop"><i class="fas fa-store"></i> Shop</a>
    <a href="/cart"><i class="fas fa-shopping-cart"></i> Cart</a>
    <a href="/checkout"><i class="fas fa-check-circle"></i> Checkout</a>
    
    @if($requestStatus === 'approved')
        <a href="/users/products/create"><i class="fas fa-plus"></i> Add New Product</a>
        <a href="/users/products/all"><i class="fas fa-box"></i> All Products</a>
        <a href="/users/ordered-products"><i class="fas fa-receipt"></i> My Orders</a>
    @elseif($requestStatus === 'pending')
        <div class="pending-message">Pending Request</div>
    @else
        <a href="/seller-request/create"><i class="fas fa-user-plus"></i> Become a Seller</a>
    @endif
    
    <a href="/users/orders"><i class="fas fa-list"></i> All Orders</a>
    <a href="{{ route('profile.settings', auth()->user()->id) }}"><i class="fas fa-cog"></i> Settings</a>
    <a href="/contact"><i class="fas fa-question-circle"></i> Support</a>

    <form method="POST" action="/logout">
        @csrf
        @method('DELETE')
        <button><i class="fas fa-sign-out-alt"></i> Log Out</button>
    </form>
</div>

<script>
    document.getElementById('toggleSidebar').addEventListener('click', function() {
        const sidebar = document.querySelector('.sidebar');
        const content = document.querySelector('.content');

        if (sidebar.style.transform === 'translateX(0%)') {
            sidebar.style.transform = 'translateX(-100%)'; // Hide sidebar
            content.style.marginLeft = '0'; // Reset content margin
        } else {
            sidebar.style.transform = 'translateX(0%)'; // Show sidebar
            content.style.marginLeft = '270px'; // Adjust content margin
        }
    });
</script>

