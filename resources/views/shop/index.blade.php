@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-semibold mb-4">Shop</h1>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
@foreach ($products as $p)
    <div class="bg-white rounded shadow overflow-hidden">
        @if($p->image_url)
            <img src="{{ $p->image_url }}" alt="{{ $p->name }}" class="w-full h-48 object-cover">
        @endif
        <div class="p-4 space-y-2">
            <div class="font-semibold">{{ $p->name }}</div>
            <div class="text-sm text-gray-600">{{ Str::limit($p->description, 80) }}</div>
            <div class="font-bold">₹{{ number_format($p->price_cents/100, 2) }}</div>
            <form method="POST" action="{{ route('cart.add', $p) }}" class="flex items-center gap-2">
                @csrf
                <input type="number" name="quantity" value="1" min="1" class="w-20 border rounded p-1">
                <button class="px-3 py-2 bg-blue-600 text-white rounded">Add to Cart</button>
            </form>
        </div>
    </div>
@endforeach
</div>

<div class="mt-6">{{ $products->links() }}</div>
@endsection
