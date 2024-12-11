<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart; // Pastikan model Cart sesuai dengan nama model Anda

class CheckoutController extends Controller
{
    public function index()
    {
        // Ambil data keranjang (sesuaikan dengan struktur database Anda)
        $cartItems = Cart::with('product')->get();

        // Hitung subtotal
        $subtotal = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

        // Biaya pengiriman (misalnya tetap)
        $shippingCost = 10000;

        // Total keseluruhan
        $total = $subtotal + $shippingCost;

        // Kirim data ke view checkout.index
        return view('checkout.index', compact('cartItems', 'subtotal', 'shippingCost', 'total'));
    }
}
