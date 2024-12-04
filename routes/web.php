<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PesanController;
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

    // Checkout
    Route::name('cekout.')->group(function () {
        Route::post('/cekout/{productId}', [PesanController::class, 'add'])->name('add');
        Route::get('/cekout', [PesanController::class, 'index'])->name('index');
        Route::delete('/cekout/{id}', [PesanController::class, 'remove'])->name('remove');
    });
});

// Rute Otentikasi
require __DIR__.'/auth.php';