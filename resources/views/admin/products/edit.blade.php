@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-semibold mb-4">Edit Product</h1>
<form method="POST" action="{{ route('products.update', $product) }}" class="bg-white p-4 rounded shadow space-y-3">
    @csrf @method('PUT')
    @include('admin.products.form', ['product' => $product])
    <button class="px-4 py-2 bg-blue-600 text-white rounded">Update</button>
</form>
@endsection
