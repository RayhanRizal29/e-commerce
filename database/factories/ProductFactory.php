<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'price' => $this->faker->randomFloat(2, 10, 100), // Harga antara 10-100
            'category_id' => $this->faker->numberBetween(1, 10), // Pastikan kategori tersedia
            'is_published' => $this->faker->boolean(),
            'stock' => $this->faker->numberBetween(10, 100),
            'images' => $this->has(ProductImageFactory::new()->count(3), 'images'),
        ];
    }
}
