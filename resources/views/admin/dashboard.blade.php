<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard - E-commerce</title>
</head>
<body>
    <h1>Admin Dashboard</h1>
    <ul>
        <li><a href="{{ route('admin.products') }}">Manage Products</a></li>
        <li><a href="{{ route('admin.orders') }}">Manage Orders</a></li>
        <li><a href="{{ route('admin.cms') }}">Manage CMS Pages</a></li>
    </ul>
</body>
</html>
