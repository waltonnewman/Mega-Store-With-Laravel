<x-layout>
    <x-slot:heading>
        Shop Page
    </x-slot:heading>

    <div class="px-10">

        <section class="pt-10">
            <div class="grid lg:grid-cols-4 gap-8 mt-6">
                @foreach($products as $product) <!-- Loop through each product -->
                    <!-- Single Product -->
                    <div class="border p-4 rounded">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-auto">
                        <h2 class="mt-2 text-lg font-semibold">{{ $product->name }}</h2>
                        <span class="text-gray-500 line-through">{{ $product->sale_price }}</span>
                        <span class="text-red-500 font-bold">{{ $product->price }}</span>
                    </div>
                @endforeach
            </div>
        </section>

    </div>
</x-layout>
