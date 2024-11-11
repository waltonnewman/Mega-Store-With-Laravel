@props(['product'])

<x-panel class="flex flex-col text-center">
    <div class="self-start text-sm">{{ $product->user->name }}</div>

    <div class="py-8">
        <h3 class="group-hover:text-blue-800 text-xl font-bold transition-colors duration-300">
            <a href="{{ route('products.show', $product->slug) }}" target="_blank">
                {{ $product->title }}
            </a>
        </h3>
        <p class="text-sm mt-4">${{ number_format($product->price, 2) }}</p>
    </div>

    <div class="flex justify-between items-center mt-auto">
        <div>
            @foreach($product->categories as $category)
                <x-tag :tag="$category->name" size="small" />
            @endforeach
        </div>

        <x-employer-logo :user="$product->image" :width="42" />
    </div>
</x-panel>
