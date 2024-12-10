<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;

class CartController extends Controller
{
    public function add(Request $request, $productId)
    {
        // Validasi input
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // Ambil produk berdasarkan ID
        $product = Product::findOrFail($productId);

        // Tambahkan data ke tabel carts
        Cart::create([
            'user_id' => auth()->id(), // Ambil ID user yang sedang login
            'product_id' => $product->id,
            'quantity' => $request->quantity,
            'price' => $product->price, // Harga produk
        ]);

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }
}
