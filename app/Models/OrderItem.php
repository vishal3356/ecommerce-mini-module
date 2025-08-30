<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id', 'product_id', 'name', 'price_cents', 'quantity'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
