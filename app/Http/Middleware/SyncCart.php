<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\CartService;

class SyncCart
{
    protected $cart;

    public function __construct(CartService $cart)
    {
        $this->cart = $cart;
    }

    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && !$request->session()->get('cart.synced')) {
            $this->cart->mergeSessionIntoUser(Auth::id());
            $request->session()->put('cart.synced', true);
        }
        return $next($request);
    }
}
