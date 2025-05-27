<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container mx-auto mt-10 max-w-md">
        <h1 class="text-2xl font-bold mb-6">Register</h1>
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>- {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ url('/register') }}">
            @csrf
            <div class="mb-4">
                <label for="name" class="block mb-1 font-semibold">Name</label>
                <input type="text" id="name" name="name" required class="w-full border border-gray-300 rounded px-3 py-2" value="{{ old('name') }}">
            </div>
            <div class="mb-4">
                <label for="email" class="block mb-1 font-semibold">Email</label>
                <input type="email" id="email" name="email" required class="w-full border border-gray-300 rounded px-3 py-2" value="{{ old('email') }}">
            </div>
            <div class="mb-4">
                <label for="password" class="block mb-1 font-semibold">Password</label>
                <input type="password" id="password" name="password" required class="w-full border border-gray-300 rounded px-3 py-2">
            </div>
            <div class="mb-4">
                <label for="password_confirmation" class="block mb-1 font-semibold">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required class="w-full border border-gray-300 rounded px-3 py-2">
            </div>
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Register</button>
        </form>
        <p class="mt-4">Already have an account? <a href="{{ url('/login') }}" class="text-blue-600 hover:underline">Login here</a></p>
    </div>
</body>
</html>
