<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\CartItem;
use App\Models\Product;

class CartService
{
    public function sessionKey(): string
    {
        return 'cart.items';
    }

    public function getSessionId(): string
    {
        return Session::getId();
    }

    public function items()
    {
        if (Auth::check()) {
            return CartItem::with('product')
                ->where('user_id', Auth::id())
                ->get();
        }

        $items = collect(Session::get($this->sessionKey(), []));
        $productIds = $items->pluck('product_id')->all();
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

        return $items->map(function ($line) use ($products) {
            $line['product'] = $products[$line['product_id']] ?? null;
            return (object)$line;
        });
    }

    public function add(Product $product, int $qty = 1): void
    {
        if ($qty < 1) $qty = 1;

        if (Auth::check()) {
            $item = CartItem::firstOrNew([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
            ]);
            $item->quantity = ($item->quantity ?? 0) + $qty;
            $item->save();
            return;
        }

        $items = collect(Session::get($this->sessionKey(), []));
        $index = $items->search(fn ($l) => $l['product_id'] === $product->id);
        if ($index === false) {
            $items->push(['product_id' => $product->id, 'quantity' => $qty]);
        } else {
            $line = $items[$index];
            $line['quantity'] += $qty;
            $items[$index] = $line;
        }
        Session::put($this->sessionKey(), $items->values()->all());
    }

    public function update(Product $product, int $qty): void
    {
        $qty = max(0, $qty);
        if (Auth::check()) {
            $item = CartItem::where('user_id', Auth::id())
                ->where('product_id', $product->id)->first();
            if ($item) {
                if ($qty === 0) $item->delete();
                else { $item->quantity = $qty; $item->save(); }
            } elseif ($qty > 0) {
                CartItem::create([
                    'user_id' => Auth::id(),
                    'product_id' => $product->id,
                    'quantity' => $qty,
                ]);
            }
            return;
        }

        $items = collect(Session::get($this->sessionKey(), []));
        $index = $items->search(fn ($l) => $l['product_id'] === $product->id);
        if ($index === false && $qty > 0) {
            $items->push(['product_id' => $product->id, 'quantity' => $qty]);
        } elseif ($index !== false) {
            if ($qty === 0) $items->forget($index);
            else {
                $line = $items[$index];
                $line['quantity'] = $qty;
                $items[$index] = $line;
            }
        }
        Session::put($this->sessionKey(), $items->values()->all());
    }

    public function remove(Product $product): void
    {
        $this->update($product, 0);
    }

    public function clear(): void
    {
        if (Auth::check()) {
            CartItem::where('user_id', Auth::id())->delete();
            return;
        }
        Session::forget($this->sessionKey());
    }

    public function subtotalCents(): int
    {
        return $this->items()->reduce(function ($carry, $line) {
            $product = $line->product ?? null;
            if (!$product) return $carry;
            return $carry + ($product->price_cents * $line->quantity);
        }, 0);
    }

    public function count(): int
    {
        return $this->items()->sum('quantity');
    }

    public function mergeSessionIntoUser(int $userId): void
    {
        $items = collect(Session::get($this->sessionKey(), []));
        foreach ($items as $line) {
            $item = CartItem::firstOrNew([
                'user_id' => $userId,
                'product_id' => $line['product_id'],
            ]);
            $item->quantity = ($item->quantity ?? 0) + (int)$line['quantity'];
            $item->save();
        }
        Session::forget($this->sessionKey());
    }
}
