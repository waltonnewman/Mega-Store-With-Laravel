
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Admin Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
</head>
<body>

    <nav class="flex justify-between items-center py-4 border-b-border-white/10">
        <div>
            
        </div>

        <div class="space-x-6 font-bold flex">
            <h2>Walton Tech</h2>
            
        </div>

        <div class="space-x-6 font-bold flex">
              @foreach($cart as $item)
              
            @endforeach
            <span class="icon">🔔<sup class="count" style="color: white;">{{ count($cart) }}</sup></span>
        </div>
        @auth
                <div class="space-x-6 font-bold flex">

                        <button id="toggleSidebar" style="background: none; border: none; cursor: pointer;">
                           <i class="fas fa-bars"></i> <!-- Font Awesome menu icon -->
                        </button>
                 
                </div>
            @endauth

            @guest
                <div class="space-x-6 font-bold">
                    <a href="/register">Sign Up</a>
                    <a href="/login">Log In</a>
                </div>
            @endguest
        </nav>

          <!-- Search Section -->
        
        <section class="text-center pt-6">
            <h1 class="font-bold text-4xl">Let's Find Your Next Products</h1>

    <form action="{{ route('search') }}" method="GET" class="mt-6">
    <input type="text" name="q" placeholder="Laptops..." class="rounded-xl bg-white/5 border-gray px-5 py-4 w-full max-w-xl">
    <button type="submit" class="bg-blue-600 text-white rounded-full px-4 py-2">Search</button>
</form>
        </section>

       <!-- Sidebar Section -->  

   <!-- Include sidebar here -->
    

     <!-- Content Section -->
    <div class="content">
        @yield('content') <!-- Main content goes here -->
    </div>
</body>
</html>
