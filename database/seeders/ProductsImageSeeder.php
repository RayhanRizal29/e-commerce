<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductsImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $products = \App\Models\Product::all();

        foreach ($products as $product) {
            ProductImage::factory()->create([
                'product_id' => $product->id,
            ]);
        }
    }
}
