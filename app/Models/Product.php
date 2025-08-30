<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'price_cents', 'image_url', 'is_active', 'stock'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'price_cents' => 'integer',
        'stock' => 'integer',
    ];

    public function getPriceAttribute()
    {
        return $this->price_cents / 100;
    }
}
