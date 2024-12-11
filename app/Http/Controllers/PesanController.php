<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Cart;
use App\Models\OrderDetail;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class PesanController extends Controller
{
    public function index()
{
    // Ambil produk yang ada di keranjang pengguna
    $cartItems = Cart::where('user_id', Auth::id())->get();

    // Hitung subtotal berdasarkan produk dan jumlah dalam keranjang
    $subtotal = $cartItems->sum(function($item) {
        return $item->product->price * $item->quantity;
    });

    // Tentukan biaya pengiriman tetap (dapat disesuaikan)
    $shippingCost = 50000;

    // Hitung total harga dengan menambahkan biaya pengiriman
    $total = $subtotal + $shippingCost;

    // Kirim data ke view
    return view('checkout.index', compact('cartItems', 'subtotal', 'shippingCost', 'total'));
}

public function checkout()
{
    // Ambil produk dalam keranjang untuk user yang sedang login
    $cartItems = Cart::where('user_id', Auth::id())->get();

    // Hitung subtotal dan total harga
    $subtotal = $cartItems->sum(function($item) {
        return $item->product->price * $item->quantity;
    });

    $shippingCost = 50000; // Biaya pengiriman tetap
    $total = $subtotal + $shippingCost;

    return view('checkout.index', compact('cartItems', 'subtotal', 'shippingCost', 'total'));
}

    public function add(Request $request, $productId)
{
    // Validasi input
    $request->validate([
        'quantity' => 'required|integer|min:1',
    ]);

    // Cari produk berdasarkan ID
    $product = Product::findOrFail($productId);

    // Periksa apakah produk sudah ada di keranjang user
    $existingCartItem = Cart::where('user_id', Auth::id())
        ->where('product_id', $productId)
        ->first();

    if ($existingCartItem) {
        // Jika produk sudah ada, tambahkan jumlahnya
        $existingCartItem->update([
            'quantity' => $existingCartItem->quantity + $request->quantity,
            'price' => $product->price * ($existingCartItem->quantity + $request->quantity),
        ]);
    } else {
        // Jika belum, tambahkan produk ke tabel carts
        Cart::create([
            'user_id' => Auth::id(),
            'product_id' => $productId,
            'quantity' => $request->quantity,
            'price' => $product->price * $request->quantity,
        ]);
    }

        return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }
    public function cart()
    {
        $cartItems = Cart::where('user_id', Auth::id())->get(); // Ambil produk di keranjang untuk user yang sedang login

        return view('index', compact('cartItems'));
    }

    public function updateCart(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $quantity = $request->input('quantity');

        // Get the user's active order (the one with status 0)
        $pesanan_utama = Order::where('user_id', Auth::user()->id)
            ->where('status', 0) // Pending orders only
            ->firstOrFail();

        // Check if the product exists in the order details
        $orderDetail = OrderItem::where('order_id', $pesanan_utama->id)
            ->where('product_id', $productId)
            ->first();

        if (!$orderDetail) {
            throw ValidationException::withMessages([
                'product' => 'This product is not in your cart.',
            ]);
        }

        // Check if the requested quantity is available in stock
        $product = Product::findOrFail($productId);
        if ($product->stock < $quantity) {
            throw ValidationException::withMessages([
                'quantity' => 'Requested quantity exceeds stock.',
            ]);
        }

        // Update the quantity and price
        $orderDetail->update([
            'quantity' => $quantity,
            'price' => $product->price * $quantity,
        ]);

        // Update the total price of the order
        $this->updateOrderTotal($pesanan_utama);

        return redirect()->route('checkout')->with('success', 'Cart updated successfully!');
    }

    public function removeFromCart($productId)
    {
        $pesanan_utama = Order::where('user_id', Auth::user()->id)
            ->where('status', 0) // Pending orders only
            ->firstOrFail();

        // Find the product in the order details
        $orderDetail = OrderItem::where('order_id', $pesanan_utama->id)
            ->where('product_id', $productId)
            ->first();

        if ($orderDetail) {
            // Remove the item from the order details
            $orderDetail->delete();

            // Update the order total after removal
            $this->updateOrderTotal($pesanan_utama);

            return redirect()->route('checkout')->with('success', 'Product removed from cart.');
        }

        return redirect()->route('checkout')->with('error', 'Product not found in cart.');
    }
    

    public function completeCheckout(Request $request)
    {
        // Validate the address and other necessary fields
        $validatedData = $request->validate([
            'address' => 'required|string|max:255',
        ]);

        $pesanan_utama = Order::where('user_id', Auth::user()->id)
            ->where('status', 0) // Pending orders only
            ->firstOrFail();

        // Update the order with the validated address
        $pesanan_utama->update([
            'address' => $validatedData['address'],
            'status' => 1, // Set the status to 'completed' or 'processed'
        ]);

        // Update the stock for all the products in the order
        $cartItems = OrderItem::where('order_id', $pesanan_utama->id)->get();
        foreach ($cartItems as $item) {
            $product = $item->product;
            $product->decrement('stock', $item->quantity);
        }

        return redirect()->route('order.history')->with('success', 'Checkout completed successfully.');
    }

    private function updateOrderTotal(Order $order)
    {
        // Recalculate the total price for the order
        $orderDetails = OrderItem::where('order_id', $order->id)->get();
        $subtotal = $orderDetails->sum(function ($item) {
            return $item->quantity * $item->price;
        });

        $shippingCost = 50000; // Fixed or dynamic shipping cost
        $total = $subtotal + $shippingCost;

        // Update the total price of the order
        $order->update([
            'total_price' => $total,
        ]);
    }
}
