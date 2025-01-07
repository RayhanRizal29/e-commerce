<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'image_path'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    protected $model = ProductImage::class;

    public function definition()
    {
        return [
            'product_id' => Product::factory(), // Generate product terkait
            'image_path' => $this->faker->imageUrl(640, 480, 'products', true), // URL gambar dummy
        ];
    }
}
