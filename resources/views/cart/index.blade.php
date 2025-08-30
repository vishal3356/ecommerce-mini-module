@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-semibold mb-4">Your Cart</h1>

@if ($items->isEmpty())
    <div class="bg-white p-4 rounded shadow">Your cart is empty.</div>
@else
    <div class="bg-white rounded shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="text-left p-3">Product</th>
                    <th class="text-left p-3">Price</th>
                    <th class="text-left p-3">Qty</th>
                    <th class="text-left p-3">Line Total</th>
                    <th class="p-3"></th>
                </tr>
            </thead>
            <tbody>
            @foreach ($items as $line)
                @php $product = $line->product; @endphp
                @if ($product)
                <tr class="border-t">
                    <td class="p-3">{{ $product->name }}</td>
                    <td class="p-3">₹{{ number_format($product->price_cents/100, 2) }}</td>
                    <td class="p-3">
                        <form method="POST" action="{{ route('cart.update', $product) }}" class="flex items-center gap-2">
                            @csrf @method('PATCH')
                            <input type="number" name="quantity" value="{{ $line->quantity }}" min="0" class="w-20 border rounded p-1">
                            <button class="px-3 py-1 bg-yellow-500 text-white rounded">Update</button>
                        </form>
                    </td>
                    <td class="p-3">₹{{ number_format(($product->price_cents*$line->quantity)/100, 2) }}</td>
                    <td class="p-3 text-right">
                        <form method="POST" action="{{ route('cart.remove', $product) }}">
                            @csrf @method('DELETE')
                            <button class="px-3 py-1 bg-red-600 text-white rounded">Remove</button>
                        </form>
                    </td>
                </tr>
                @endif
            @endforeach
            </tbody>
        </table>
        <div class="p-4 flex justify-between items-center">
            <form method="POST" action="{{ route('cart.clear') }}">
                @csrf @method('DELETE')
                <button class="px-4 py-2 bg-gray-200 rounded">Clear Cart</button>
            </form>
            <div class="text-right">
                <div class="text-lg font-semibold">Subtotal: ₹{{ number_format($subtotal/100, 2) }}</div>
                <div class="text-sm text-gray-600">Use the API <code>POST /api/checkout</code> to place your order.</div>
            </div>
        </div>
    </div>
@endif
@endsection
