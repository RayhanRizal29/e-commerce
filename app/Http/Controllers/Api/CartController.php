<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    //
    public function addToCart(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // Periksa apakah produk sudah ada di keranjang
        $cartItem = Cart::where('user_id', $validated['user_id'])
            ->where('product_id', $validated['product_id'])
            ->first();

        if ($cartItem) {
            // Update jumlah
            $cartItem->quantity += $validated['quantity'];
            $cartItem->save();
        } else {
            // Tambahkan item baru
            Cart::create($validated);
        }

        return response()->json(['message' => 'Item added to cart successfully!'], 201);
    }

    public function removeFromCart(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
        ]);

        // Periksa apakah produk sudah ada di keranjang
        $cartItem = Cart::where('user_id', $validated['user_id'])
            ->where('product_id', $validated['product_id'])
            ->first();

        if ($cartItem) {
            $cartItem->delete();
        }

        return response()->json(['message' => 'Item removed from cart successfully!'], 200);
    }

    public function getCart(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $cartItems = Cart::where('user_id', $validated['user_id'])->get();

        return response()->json($cartItems, 200);
    }

    public function updateCartQuantity(Request $request)
{
    $validated = $request->validate([
        'user_id' => 'required|exists:users,id',
        'product_id' => 'required|exists:products,id',
        'quantity' => 'required|integer|min:1',
    ]);

    // Cari item cart berdasarkan user_id dan product_id
    $cartItem = Cart::where('user_id', $validated['user_id'])
        ->where('product_id', $validated['product_id'])
        ->first();

    if (!$cartItem) {
        return response()->json(['message' => 'Item not found in the cart!'], 404);
    }

    // Perbarui jumlah item
    $cartItem->quantity = $validated['quantity'];
    $cartItem->save();

    return response()->json(['message' => 'Cart quantity updated successfully!', 'cart' => $cartItem], 200);
}

}
