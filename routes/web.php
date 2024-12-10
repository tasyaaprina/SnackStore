<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PesanController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

// Halaman Utama
Route::get('/', function () {
    return view('welcome');
});

// Dashboard
Route::get('/dashboard', [HomeController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Rute dengan middleware 'auth'
Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Produk
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

    Route::post('/cart/add/{product}', [PesanController::class, 'add'])->middleware('auth')->name('cekout.add');
    Route::get('/cart', [PesanController::class, 'cart'])->middleware('auth')->name('cart.index');
    Route::get('/checkout', [PesanController::class, 'checkout'])->name('checkout');
    Route::get('/checkout', [PesanController::class, 'index'])->name('checkout.index');


});

// Rute Otentikasi
require __DIR__.'/auth.php';