@component('mail::message')
# New Order Received!

A new order has been placed.

**Order ID:** {{ $order->id }}

@component('mail::table')
| Product Name | Quantity | Price |
|--------------|----------|-------|
@foreach ($order->items as $item)
| {{ $item->product_name }} | {{ $item->quantity }} | {{ number_format($item->price, 2) }} |
@endforeach
@endcomponent

Please check the order in your dashboard.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
