<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['Laravel T-Shirt', 1999, 'https://picsum.photos/seed/laravel/600/400'],
            ['PHP Mug', 1299, 'https://picsum.photos/seed/php/600/400'],
            ['Dev Notebook', 899, 'https://picsum.photos/seed/notebook/600/400'],
            ['Sticker Pack', 499, 'https://picsum.photos/seed/stickers/600/400'],
        ];

        foreach ($items as [$name, $price_cents, $image]) {
            Product::updateOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'name' => $name,
                    'description' => 'Sample product for demo purposes.',
                    'price_cents' => $price_cents,
                    'image_url' => $image,
                    'is_active' => true,
                    'stock' => 100,
                ]
            );
        }
    }
}
