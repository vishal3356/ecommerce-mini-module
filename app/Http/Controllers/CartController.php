<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Services\CartService;

class CartController extends Controller
{
    protected $cart;

    public function __construct(CartService $cart)
    {
        $this->cart = $cart;
    }

    public function index()
    {
        $items = $this->cart->items();
        $subtotal = $this->cart->subtotalCents();
        return view('cart.index', compact('items', 'subtotal'));
    }

    public function add(Request $request, Product $product)
    {
        $qty = (int) $request->input('quantity', 1);
        $this->cart->add($product, $qty);
        return redirect()->route('cart.index')->with('status', 'Added to cart.');
    }

    public function update(Request $request, Product $product)
    {
        $qty = (int) $request->input('quantity', 1);
        $this->cart->update($product, $qty);
        return back()->with('status', 'Cart updated.');
    }

    public function remove(Product $product)
    {
        $this->cart->remove($product);
        return back()->with('status', 'Removed item.');
    }

    public function clear()
    {
        $this->cart->clear();
        return back()->with('status', 'Cart cleared.');
    }
}
