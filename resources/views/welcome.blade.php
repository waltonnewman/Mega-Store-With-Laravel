<x-layout>
    <div class="space-y-10">

        <!-- Hero Section -->
        <section class="bg-blue-600 text-white text-center py-20">
            <h1 class="text-5xl font-bold">Welcome to Our Mega Store Product Showcase</h1>
            <p class="mt-4 text-lg">Discover amazing products tailored just for you.</p>
            <a href="/shop" class="mt-6 inline-block bg-red text-blue-600 rounded-full px-6 py-3 font-semibold">Shop Now</a>
        </section>

        <!-- Featured Products Section -->
        <section id="featured" class="pt-10">
            <x-section-heading>Featured Products</x-section-heading>
            
             <div class="grid lg:grid-cols-4 gap-8 mt-6">
                @foreach($featuredProducts as $product)
                <a href="{{ route('products.show', $product->slug) }}">
                  <div class="border p-4 rounded-lg shadow-lg overflow-hidden">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                        <div class="p-4">
                            <h2 class="font-bold text-xl">{{ $product->name }}</h2>
                           <span class="text-red-500 font-bold line-through">{{ $product->price }}</span>
                           <span class="text-gray-500 ">{{ $product->sale_price }}</span>
                            <p href="{{ route('products.show', $product->slug) }}" class="mt-4 inline-block bg-blue-600 text-white rounded-full px-4 py-2">View Details</p>
                        </div>
                        
                    </div>
                  </a> 
                @endforeach
            </div>
        </section>

        <!-- Tags Section -->
        <section>
            <x-section-heading>Popular Tags</x-section-heading>
               
            <div class="mt-6 flex flex-wrap space-x-2">
                @foreach($tags as $tag)
                    <span class="bg-gray-200 text-gray-700 rounded-full px-3 py-1 text-sm">{{ $tag }}</span>
                @endforeach
            </div>
        </section>

        <!-- Recent Products Section -->
        <section>
            <x-section-heading>Recent Products</x-section-heading>
            <div class="grid lg:grid-cols-4 gap-8 mt-6">
                @foreach($recentProducts as $product)
                 <a href="{{ route('products.show', $product->slug) }}">
                    <div class="border p-4 rounded-lg shadow-lg overflow-hidden">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                        <div class="p-4">
                            <h2 class="font-bold text-xl">{{ $product->name }}</h2>
                            <span class="text-red-500 font-bold line-through">{{ $product->price }}</span>
                            <span class="text-gray-500 ">{{ $product->sale_price }}</span>
                            <p href="{{ route('products.show', $product->slug) }}" class="mt-4 inline-block bg-blue-600 text-white rounded-full px-4 py-2">View Details</p>
                        </div>
                    </div>
                 </a>
                @endforeach
            </div>
        </section>

    </div>
</x-layout>
