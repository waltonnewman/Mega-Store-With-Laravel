@component('mail::message')
# Thank You for Your Purchase!

Your order number is **{{ $order->id }}**.

@component('mail::table')
| Product Name | Quantity | Price |
|--------------|----------|-------|
@foreach ($order->items as $item)
| {{ $item->product_name }} | {{ $item->quantity }} | {{ number_format($item->price, 2) }} |
@endforeach
@endcomponent

You will receive an email confirmation shortly.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
