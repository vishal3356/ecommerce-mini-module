<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ShopController extends Controller
{
    public function index()
    {
        $products = Product::where('is_active', true)->latest()->paginate(12);
        return view('shop.index', compact('products'));
    }
}
