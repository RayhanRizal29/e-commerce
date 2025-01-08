<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            //
            'user_id' => User::factory(), // Relasi ke User
            'status' => $this->faker->randomElement(['pending', 'completed', 'cancelled']), // Status order
            'total_price' => $this->faker->randomFloat(2, 50, 1000), // Total harga
        ];
    }

    public function withItems()
    {
        return $this->afterCreating(function (Order $order) {
            // Membuat beberapa OrderItem (1-5) terkait dengan order yang baru dibuat
            $items = \App\Models\OrderItem::factory(rand(1, 5))->create(['order_id' => $order->id]);
         
            $totalPrice = $items->reduce(function ($carry, $item) {
                return $carry + ($item->quantity * $item->price);
            }, 0);

            // Update total price di Order
            $order->update(['total_price' => $totalPrice]);
        });
    }
}
