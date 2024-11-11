<x-layout>

<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 20px;
}

.container {
    max-width: 600px;
    margin: 0 auto;
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

p {
    font-size: 16px;
    line-height: 1.5;
    margin: 10px 0;
}

strong {
    color: #555;
}

.track {
    display: inline-block;
    margin-top: 20px;
    text-align: center;
    padding: 10px 15px;
    background-color: #007bff;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s;
}

.track:hover {
    background-color: #0056b3;
}

.btn2 {
    display: inline-block;
    margin-top: 20px;
    padding: 10px 15px;
    background-color: #28a745; /* Green color */
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s;
}

.btn2:hover {
    background-color: #218838; /* Darker green on hover */
}

@media print {
    /* Hide navigation and other non-essential elements */
    a, button, h1, input, p, h2, h3, title, span {
        display: none;
    }

    /* Optionally style the printed content */
    body {
        background: white;
        color: black;
    }
}
</style>

<div class="container">
    <h1 style="color: #333; text-align: center;">Tracking Information</h1>

    <h4 style="color: black;"><strong>Tracking Number:</strong> {{ $tracking->tracking_number }}</h4>
    <h4 style="color: black;"><strong>Carrier:</strong> {{ $tracking->carrier }}</h4>
    <h4 style="color: black;"><strong>Status:</strong> {{ $tracking->status }}</h4>
    <h4 style="color: black;"><strong>Updated At:</strong> {{ $tracking->updated_at }}</h4>

    <!-- New Customer Details Section -->
    <h4 style="color: black;"><strong>Customer Name:</strong> {{ $tracking->name }}</h4>
    <h4 style="color: black;"><strong>Email:</strong> {{ $tracking->buyer_email }}</h4>
    <h4 style="color: black;"><strong>Address:</strong> {{ $tracking->buyer_address }}</h4>
    <h4 style="color: black;"><strong>City:</strong> {{ $tracking->buyer_city }}</h4>

    <a class="track" href="{{ route('tracking.index') }}">Track another order</a>
    <button class="btn2" onclick="window.print()" style="margin-top: 20px;">Print Receipt</button>
</div>

</x-layout>
