@props(['product', 'tags'])

<x-panel class="flex gap-x-6">
    <div>
        <x-employer-logo :user="$product->name" />
    </div>

    <div class="flex-1 flex flex-col">
        <a href="#" class="self-start text-sm text-gray-400 transition-colors duration-300">{{ $product->user->name }}</a>

        <h3 class="font-bold text-xl mt-3 group-hover:text-blue-800">
            <a href="{{ $product->slug }}" target="_blank">
                {{ $product->title }}
            </a>
        </h3>

        <p class="text-sm text-gray-400 mt-auto">{{ $product->price }}</p>
    </div>

    <div>
       
    </div>
</x-panel>