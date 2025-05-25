<!DOCTYPE html>
<html>
<head>
    <title>User Profile - E-commerce</title>
</head>
<body>
    <h1>User Profile</h1>
    <p>Name: {{ auth()->user()->name }}</p>
    <p>Email: {{ auth()->user()->email }}</p>
    <a href="{{ route('user.dashboard') }}">Back to Dashboard</a>
</body>
</html>
