<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard - E-commerce</title>
</head>
<body>
    <h1>User Dashboard</h1>
    <p>Welcome, {{ auth()->user()->name }}!</p>
    <ul>
        <li><a href="{{ route('user.profile') }}">Profile</a></li>
        <li><a href="{{ route('user.orders') }}">Order History</a></li>
        <li><a href="{{ route('user.cart') }}">Cart</a></li>
    </ul>
</body>
</html>
