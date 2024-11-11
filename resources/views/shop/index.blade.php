<x-layout>
    <x-slot:heading>
        Shop Page
    </x-slot:heading>

    <div class="px-10">
        <section class="pt-10">
            <div class="grid lg:grid-cols-4 gap-8 mt-6">
                @foreach($products as $product) <!-- Loop through each product -->
                    <div class="border p-4 rounded">
                       <a href="{{ route('products.show', ['slug' => $product->slug]) }}">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-auto">
                        <h2 class="mt-2 text-lg font-semibold">{{ $product->name }}</h2>
                        <span class="text-red-500 font-bold line-through">{{ $product->price }}</span>
                        <span class="text-gray-500 ">{{ $product->sale_price }}</span>
                      </a>  
                    </div>
                @endforeach
            </div>

            <!-- Pagination Links -->
            <div class="mt-6">
                {{ $products->links() }} <!-- This will generate pagination links -->
            </div>
        </section>
    </div>
</x-layout>
