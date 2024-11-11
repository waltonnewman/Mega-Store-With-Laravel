<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>New Order</title>
</head>
<body>



    <div class="container mx-auto px-4 py-6">

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
    </div>
</body>
</html>