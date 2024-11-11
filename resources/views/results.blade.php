<x-layout>
    <div class="space-y-10">
        <h1 class="text-2xl font-bold">Search Results for "{{ $query }}"</h1>

        @if($products->isEmpty())
            <p>No products found for your search.</p>
        @else
            <div class="grid lg:grid-cols-3 gap-8 mt-6">
                @foreach($products as $product)
                   <a href="{{ route('products.show', $product->slug) }}">
                  <div class="border p-4 rounded">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-auto">
                        <div class="p-4">
                            <h2 class="font-bold text-xl">{{ $product->name }}</h2>
                           <span class="text-red-500 font-bold line-through">{{ $product->price }}</span>
                        <span class="text-gray-500 ">{{ $product->sale_price }}</span><br>
                             <p class="mt-8 inline-block bg-blue-600 text-white rounded-full px-4 py-2">View Details</p>
                        </div>
                        
                    </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</x-layout>
