<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Category::factory(5)->create()->each(function ($category) {
            $products = Product::factory(10)->create(['category_id' => $category->id]);

            // Tambahkan 1-3 gambar untuk setiap produk
            $products->each(function ($product) {
                ProductImage::factory(rand(1, 3))->create(['product_id' => $product->id]);
            });
        });

    }
}
