<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'cover_image', 
        'name',
        'description',
        'is_published',
        'category_id',
        'price',
        'stock',
       
    ];

    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->boolean('is_published')->default(true);
            $table->string('category_id');
            $table->numeric('price');
            $table->integer('stock');
            $table->timestamps();
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function carts()
    {
        return $this->belongsToMany(Cart::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class); // Pastikan ini mengembalikan relasi yang benar
    }



}
