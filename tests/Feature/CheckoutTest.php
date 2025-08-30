<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\CartItem;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_checkout_creates_order_from_db_cart()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'price_cents' => 1000,
            'is_active' => true,
        ]);

        CartItem::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        $payload = [
            'customer_name' => 'Jane Doe',
            'customer_email' => 'jane@example.com',
            'shipping_address' => '123 Street',
            'payment_method' => 'cod',
        ];

        $response = $this->actingAs($user)->postJson('/api/checkout', $payload);
        $response->assertCreated()->assertJsonPath('order.total_cents', 2000);
        $this->assertDatabaseHas('orders', ['user_id' => $user->id, 'total_cents' => 2000]);
        $this->assertDatabaseCount('order_items', 1);
    }
}
