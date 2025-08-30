@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between mb-4">
    <h1 class="text-2xl font-semibold">Products</h1>
    <a class="px-4 py-2 bg-blue-600 text-white rounded" href="{{ route('products.create') }}">New</a>
</div>

<table class="w-full bg-white shadow rounded overflow-hidden">
    <thead class="bg-gray-100">
        <tr>
            <th class="text-left p-3">#</th>
            <th class="text-left p-3">Name</th>
            <th class="text-left p-3">Price</th>
            <th class="text-left p-3">Active</th>
            <th class="text-left p-3">Stock</th>
            <th class="p-3">Actions</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($products as $p)
        <tr class="border-t">
            <td class="p-3">{{ $p->id }}</td>
            <td class="p-3">{{ $p->name }}</td>
            <td class="p-3">₹{{ number_format($p->price_cents/100, 2) }}</td>
            <td class="p-3">{{ $p->is_active ? 'Yes' : 'No' }}</td>
            <td class="p-3">{{ $p->stock }}</td>
            <td class="p-3 text-right">
                <a href="{{ route('products.edit', $p) }}" class="px-3 py-1 bg-yellow-500 text-white rounded">Edit</a>
                <form method="POST" action="{{ route('products.destroy', $p) }}" class="inline">
                    @csrf @method('DELETE')
                    <button class="px-3 py-1 bg-red-600 text-white rounded" onclick="return confirm('Delete?')">Delete</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

<div class="mt-4">{{ $products->links() }}</div>
@endsection
