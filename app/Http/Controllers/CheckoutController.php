<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Services\CartService;
use App\Models\Order;
use App\Models\OrderItem;

class CheckoutController extends Controller
{
    protected $cart;

    public function __construct(CartService $cart)
    {
        $this->cart = $cart;
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_name' => ['required','string','max:255'],
            'customer_email' => ['required','email','max:255'],
            'shipping_address' => ['required','string','max:1000'],
            'payment_method' => ['required','string','in:cod,card,upi'],
        ]);

        $items = $this->cart->items();
        if ($items->isEmpty()) {
            return response()->json(['message' => 'Cart is empty'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $total = $this->cart->subtotalCents();

        $order = Order::create([
            'user_id' => Auth::id(),
            'customer_name' => $data['customer_name'],
            'customer_email' => $data['customer_email'],
            'shipping_address' => $data['shipping_address'],
            'payment_method' => $data['payment_method'],
            'total_cents' => $total,
            'status' => 'pending',
        ]);

        foreach ($items as $line) {
            $product = $line->product;
            if (!$product) continue;
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'name' => $product->name,
                'price_cents' => $product->price_cents,
                'quantity' => $line->quantity,
            ]);
        }

        // clear cart after checkout
        $this->cart->clear();

        return response()->json([
            'message' => 'Order created',
            'order' => $order->load('items')
        ], Response::HTTP_CREATED);
    }
}
