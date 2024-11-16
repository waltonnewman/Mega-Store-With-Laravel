<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
	<title>Amazing Mega Store</title>

	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css2?family=Kanken+Grotesk:wght@200..900&display=swap
">
	@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-black text-white font-hanken-grotesk">

<div class="">
	<nav class="flex justify-between items-center py-4 border-b border-white/10" style="background-color: #036645;">
    <div class="font-bold text-4xl px-5">
        <a href="/">
            Mega <span style="color: #7F1153;">Store</span>
        </a>
    </div>

    <div class="flex-grow flex justify-center">
        <form action="{{ route('search') }}" method="GET" class="w-full max-w-3xl rounded-xl">
            <input type="text" name="q" placeholder="Search Mega Store..." class="rounded-xl bg-white border border-white/10 px-5 py-2" style="width: 600px">
            <button type="submit" class="text-white rounded px-4 py-2 mr-9" style="background-color: #7F1153;"><i class="fas fa-search"></i></button>
        </form>
    </div>

    @auth
        <div class="space-x-6 font-bold flex items-center">
            @foreach($cart as $item)
            @endforeach
            <span class="icon"><i class="fas fa-shopping-cart"></i><sup class="count" style="color: #7F1153;">{{ count($cart) }}</sup></span>
            <a href="/users/dashboard">Dashboard</a>
            <a href="/products/create">Add New Product</a>

            <form method="POST" action="/logout" class="inline">
                @csrf
                @method('DELETE')
                <button class="text-white">Log Out</button>
            </form>
        </div>
    @endauth

    @guest
        <div class="space-x-6 font-bold flex items-center px-5">
            @foreach($cart as $item)
            @endforeach
            <span class="icon"><i class="fas fa-shopping-cart"></i><sup class="count" style="color: red;">{{ count($cart) }}</sup></span>
            <a href="/register">Sign Up</a>
            <a href="/login">Log In</a>
        </div>
    @endguest
</nav>


        <!-- Search Section -->
        
        <section class="text-center pt-6">
            <h1 class="font-bold text-4xl">Let's Find Your Next Products</h1>
<!--
    <form action="{{ route('search') }}" method="GET" class="mt-6">
    <input type="text" name="q" placeholder="Laptops..." class="rounded-xl bg-white/5 border-white/10 px-5 py-4 w-full max-w-xl">
    <button type="submit" class="bg-blue-600 text-white rounded-full px-4 py-2">Search</button>
</form>-->

  
            <a href="/">Home</a>
            <a href="/shop">Shop</a>
            <a href="/cart">Cart</a>
            <a href="/checkout">Checkout</a>
            <a href="/contact">Contact</a>
        </section>


        <main class="mt-10 max-w-[986px] mx-auto">
            {{$slot}}
        </main>
      

      <div class="grid lg:grid-cols-4 gap-8 mt-6 text-white-400">
               <div>
                   <p>
                       A new User is created with the validated user attributes.
The uploaded logo file is stored in the logos directory, and its path is saved.
An associated employer record is created for the user, storing the employer's name and logo path.
                   </p>
               </div>
               <div>
                   <p>
                       A new User is created with the validated user attributes.
The uploaded logo file is stored in the logos directory, and its path is saved.
An associated employer record is created for the user, storing the employer's name and logo path.
                   </p>
               </div>
               <div>
                  <p>
                      A new User is created with the validated user attributes.
The uploaded logo file is stored in the logos directory, and its path is saved.
An associated employer record is created for the user, storing the employer's name and logo path.
                  </p> 
               </div>

               <div class=" font-bold display-block">
                <h3>Quick Links</h3>
            <a href="/">Home</a><br>
            <a href="#">About</a><br>
            <a href="#">Services</a><br>
            <a href="#">Contact</a><br>
              </div>


            </div>
</div>
</body>
</html>