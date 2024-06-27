<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/', [ProductController::class, 'index'])->name('products.index');
Route::get('/search', [ProductController::class, 'search'])->name('products.search');
Route::get('/filter', [ProductController::class, 'filter'])->name('products.filter');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/orders', [AdminController::class, 'orders'])->name('admin.orders');
    Route::post('/admin/orders/confirm/{id}', [AdminController::class, 'confirmOrder'])->name('admin.orders.confirm');
    //Route::delete('/admin/orders/cancel/{id}', [AdminController::class, 'cancelOrder'])->name('admin.orders.cancel');

    Route::get('/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products/create', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

    Route::get('/sizes', [SizeController::class, 'index'])->name('sizes.index');
    Route::post('/sizes', [SizeController::class, 'store'])->name('sizes.store');
    Route::get('/sizes/create', [SizeController::class, 'create'])->name('sizes.create');
    Route::get('/sizes/{id}/edit', [SizeController::class, 'edit'])->name('sizes.edit');
    Route::put('/sizes/{id}', [SizeController::class, 'update'])->name('sizes.update');
    Route::delete('/sizes/{id}', [SizeController::class, 'destroy'])->name('sizes.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/cart/add/{productId}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'showCart'])->name('cart.show');
    Route::post('/cart/update/{cartId}', [CartController::class, 'updateCart'])->name('cart.update');
    Route::delete('/cart/remove/{cartId}', [CartController::class, 'removeFromCart'])->name('cart.remove');

    Route::get('/checkout', [OrderController::class, 'checkout'])->name('order.checkout');
    Route::post('/place-order', [OrderController::class, 'placeOrder'])->name('order.place');
    Route::get('/order-success', [OrderController::class, 'success'])->name('order.success');
});

