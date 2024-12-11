<?php

namespace App\Http\Controllers;

use App\Models\Product; // Menggunakan model Product
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil semua produk beserta kategori (menggunakan eager loading)
        $products = Product::with('category')->get();

        // Kirim data produk dan status login ke view dashboard.blade.php
        return view('dashboard', [
            'products' => $products,
            'isLoggedIn' => Auth::check(), // Status login pengguna
        ]);
    }
}
