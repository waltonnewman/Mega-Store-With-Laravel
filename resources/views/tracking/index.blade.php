<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Your Order</title>
</head>
<body>
    <h1>Track Your Order</h1>

    @if(session('error'))
        <div style="color: red;">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('tracking.track') }}" method="POST">
        @csrf
        <label for="tracking_number">Tracking Number:</label>
        <input type="text" id="tracking_number" name="tracking_number" required>
        <button type="submit">Track</button>
    </form>
</body>
</html>
