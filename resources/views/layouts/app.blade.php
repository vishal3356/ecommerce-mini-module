<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mini Shop</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-900">
<nav class="bg-white shadow">
    <div class="max-w-6xl mx-auto px-4 py-3 flex justify-between items-center">
        <a href="{{ route('shop.index') }}" class="font-bold">Mini Shop</a>
        <div class="space-x-4">
            <a href="{{ route('cart.index') }}" class="underline">Cart</a>
            @auth
                <a href="{{ route('products.index') }}" class="underline">Admin</a>
            @endauth
        </div>
    </div>
</nav>
<main class="max-w-6xl mx-auto p-4">
    @if (session('status'))
        <div class="mb-4 p-3 rounded bg-green-100 border border-green-300">
            {{ session('status') }}
        </div>
    @endif
    @yield('content')
</main>
</body>
</html>
