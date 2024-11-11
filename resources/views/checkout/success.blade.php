<x-layout>
    <x-slot:heading>
        Order Confirmation
    </x-slot:heading>

    <div class="container mx-auto px-4 py-6">
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">Your order has been placed successfully.</span>
        </div>

        <div class="mt-6">
            <h2 class="text-xl font-bold">Thank you for your purchase!</h2>
            <p class="mt-2">Your order number is <strong>{{ $order->id }}</strong>.</p>
            <p class="mt-2">You will receive an email confirmation shortly.</p>
            <p class="mt-2">If you have any questions, feel free to <a href="/contact" class="text-blue-500 underline">contact us</a>.</p>
        </div>

        <div class="mt-6">
            <h3 class="text-lg font-semibold">Order Details:</h3>
            <ul class="list-disc list-inside">
                @foreach($order->items as $item)
                    <li>{{ $item->product_name }} - Quantity: {{ $item->quantity }} - Price: {{ number_format($item->price, 2) }}</li>
                @endforeach
            </ul>
        </div>

        <div class="mt-6">
            <a href="/shop" class="bg-blue-500 text-white px-4 py-2 rounded">Continue Shopping</a>
            <a href="/users/orders" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">View Your Orders</a>
        </div>
    </div>
</x-layout>
