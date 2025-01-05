<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //
    public function getByCategory($category)
    {
        $products = Product::whereHas('category', function ($query) use ($category) {
            $query->where('name', $category);
        })->get();

        return response()->json([
            'data' => $products
        ]);
    }

    public function index(Request $request)
    {
        $products = Product::paginate(10);

        return response()->json([
            'data' => $products
        ]);
    }
}
