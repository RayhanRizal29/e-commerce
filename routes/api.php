<?php

use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', [AuthenticationController::class, 'register']);
Route::post('login', [AuthenticationController::class, 'login']);
Route::put('/update/{id}', [AuthenticationController::class, 'update']);
Route::get('me', [AuthenticationController::class, 'me'])->middleware('auth:sanctum');

// Category product
Route::middleware('auth:sanctum')->get('/products/category/{category}', [ProductController::class, 'getByCategory']);
Route::middleware('auth:sanctum')->get('/products', [ProductController::class, 'index']);
// Route::get('products', [ProductController::class, 'index']);
// Route::get('/products', [ProductController::class, 'index']);

// Cart
Route::post('/cart/add', [CartController::class, 'addToCart']);
Route::post('/cart/remove', [CartController::class, 'removeFromCart']);
Route::get('/cart', [CartController::class, 'getCart']);
Route::put('/cart/update', [CartController::class, 'updateCartQuantity']);

// Checkout
Route::post('/checkout', [OrderController::class, 'checkout']);

// list order
Route::get('/orders', [OrderController::class, 'listOrders']);