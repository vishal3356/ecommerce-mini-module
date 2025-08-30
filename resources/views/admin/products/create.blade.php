@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-semibold mb-4">New Product</h1>
<form method="POST" action="{{ route('products.store') }}" class="bg-white p-4 rounded shadow space-y-3">
    @csrf
    @include('admin.products.form', ['product' => null])
    <button class="px-4 py-2 bg-blue-600 text-white rounded">Create</button>
</form>
@endsection
