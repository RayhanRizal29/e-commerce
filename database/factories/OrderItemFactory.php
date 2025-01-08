<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = \App\Models\OrderItem::class;
    public function definition(): array
    {
        $product = Product::factory()->create();
        return [
            //
            'order_id' => Order::factory(), // Relasi ke Order
            'product_id' => $product->id, // Relasi ke Produk
            'quantity' => $this->faker->numberBetween(1, 10), // Jumlah produk
            'price' => $product->price,
        ];
    }
}
