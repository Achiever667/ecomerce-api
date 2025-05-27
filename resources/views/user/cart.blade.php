<!DOCTYPE html>
<html>
<head>
    <title>User Cart - E-commerce</title>
</head>
<body>
    <h1>Your Cart</h1>
    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif
    @if(session('error'))
        <p style="color:red">{{ session('error') }}</p>
    @endif
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($cartItems as $item)
            <tr>
                <td>{{ $item->product->name }}</td>
                <td>
                    <form method="POST" action="{{ url('/cart/' . $item->id) }}">
                        @csrf
                        @method('PUT')
                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" required>
                        <button type="submit">Update</button>
                    </form>
                </td>
                <td>
                    <form method="POST" action="{{ url('/cart/' . $item->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Remove this item?')">Remove</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3">Your cart is empty.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <form method="POST" action="{{ url('/checkout') }}">
        @csrf
        <button type="submit" {{ $cartItems->isEmpty() ? 'disabled' : '' }}>Checkout</button>
    </form>
    <p><a href="{{ route('user.dashboard') }}">Back to Dashboard</a></p>
</body>
</html>