<?php

use App\Exports\ProductExport;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MidtransController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Maatwebsite\Excel\Facades\Excel;

Route::redirect('/', '/register');

// Role 
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('dashboard.index');
});

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
});


Route::get('/register', [AuthenticationController::class, 'register'])->name('register');
Route::post('/store', [AuthenticationController::class, 'store'])->name('store');
Route::get('/login', [AuthenticationController::class, 'login'])->name('login');
Route::post('/authenticate', [AuthenticationController::class, 'authenticate'])->name('authenticate');
Route::get('/dashboard', [AuthenticationController::class, 'dashboard'])->name('dashboard');
Route::post('/logout', [AuthenticationController::class, 'logout'])->name('logout');


Route::get('/products', [ProductController::class,'index'])->name('products.index');
Route::get('/products/create', [ProductController::class,'create'])->name('products.create');

// dataTables untuk products
Route::get('/products/data', [ProductController::class, 'getData'])->name('products.data');

Route::post('/products', [ProductController::class,'store'])->name('products.store');
Route::get('/products/{id}', [ProductController::class,'detail'])->name('products.detail');

Route::get('/products/{id}/edit', [ProductController::class,'edit'])->name('products.edit');
Route::put('/products/{id}', [ProductController::class,'update'])->name('products.update'); 
Route::delete('/products/{imageId}/delete-image', [ProductController::class, 'update'])->name('products.delete-image');


Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

// Category
Route::get('/categories', [CategoryController::class,'index'])->name('categories.index');
Route::get('/categories/create', [CategoryController::class,'create'])->name('categories.create');
Route::post('/categories', [CategoryController::class,'store'])->name('categories.store');
Route::get('/categori/{id}', [CategoryController::class,'detail'])->name('categories.detail');

// dataTables untuk categories
Route::get('/categories/data', [CategoryController::class, 'getData'])->name('categories.data');


Route::get('/categories/{id}/edit', [CategoryController::class,'edit'])->name('categories.edit');
Route::put('/categories/{id}', [CategoryController::class,'update'])->name('categories.update');
Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');

// USer
Route::get('/users', [UserController::class,'index'])->name('users.index');
// Route::get('/users/{id}', [UserController::class,'detail'])->name('users.detail');
// Route::get('/users/{id}/orders', [UserController::class,'showOrders'])->name('users.orders');
Route::get('/users/{id}/orders', [UserController::class,'showOrders'])->name('users.detail');
Route::get('/users/data', [UserController::class, 'getData'])->name('users.data');

// ORder
Route::get('/orders', [OrderController::class,'index'])->name('orders.index');
Route::get('/orders/{id}/detail', [OrderController::class,'detail'])->name('orders.detail');
Route::delete('/order/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');
Route::get('/orders/data', [OrderController::class, 'getData'])->name('orders.data');
// Route::get('/orders/create', [OrderController::class,'create'])->name('orders.create');

// Export Product
Route::get('/export-products', function () {
    return Excel::download(new ProductExport, 'products.xlsx');
})->name('export.products');

Route::delete('/img/{id}', [ProductController::class, 'destroyimg'])->name('products.destroyimg');

Route::post('/payment', [PaymentController::class, 'createTransaction']);

