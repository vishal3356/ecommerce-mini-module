<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(12);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'slug' => ['nullable','string','max:255', Rule::unique('products','slug')],
            'description' => ['nullable','string'],
            'price' => ['required','numeric','min:0'],
            'image_url' => ['nullable','url'],
            'is_active' => ['boolean'],
            'stock' => ['nullable','integer','min:0']
        ]);

        $slug = $data['slug'] ?? Str::slug($data['name']);
        Product::create([
            'name' => $data['name'],
            'slug' => $slug,
            'description' => $data['description'] ?? null,
            'price_cents' => (int) round(($data['price'] ?? 0) * 100),
            'image_url' => $data['image_url'] ?? null,
            'is_active' => $request->boolean('is_active'),
            'stock' => $data['stock'] ?? 0,
        ]);

        return redirect()->route('products.index')->with('status', 'Product created.');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'slug' => ['nullable','string','max:255', Rule::unique('products','slug')->ignore($product->id)],
            'description' => ['nullable','string'],
            'price' => ['required','numeric','min:0'],
            'image_url' => ['nullable','url'],
            'is_active' => ['boolean'],
            'stock' => ['nullable','integer','min:0']
        ]);

        $slug = $data['slug'] ?? $product->slug ?? Str::slug($data['name']);
        $product->update([
            'name' => $data['name'],
            'slug' => $slug,
            'description' => $data['description'] ?? null,
            'price_cents' => (int) round(($data['price'] ?? 0) * 100),
            'image_url' => $data['image_url'] ?? null,
            'is_active' => $request->boolean('is_active'),
            'stock' => $data['stock'] ?? 0,
        ]);

        return redirect()->route('products.index')->with('status', 'Product updated.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return back()->with('status', 'Product deleted.');
    }
}
