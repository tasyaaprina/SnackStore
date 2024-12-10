@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-2xl font-semibold mb-4">Checkout</h1>

        <!-- Cart Items Table -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="w-full table-auto border-collapse">
                <thead>
                    <tr>
                        <th class="border-b border-gray-300 px-4 py-2">Nama Produk</th>
                        <th class="border-b border-gray-300 px-4 py-2">Jumlah</th>
                        <th class="border-b border-gray-300 px-4 py-2">Harga</th>
                        <th class="border-b border-gray-300 px-4 py-2">Total Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cartItems as $item)
                        <tr>
                            <td class="border-b border-gray-300 px-4 py-2">{{ $item->product->name }}</td>
                            <td class="border-b border-gray-300 px-4 py-2">{{ $item->quantity }}</td>
                            <td class="border-b border-gray-300 px-4 py-2">{{ number_format($item->product->price, 2) }}</td>
                            <td class="border-b border-gray-300 px-4 py-2">{{ number_format($item->product->price * $item->quantity, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Order Summary -->
        <div class="mt-6 bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Ringkasan Pesanan</h2>

            <div class="flex justify-between">
                <p class="font-medium">Subtotal:</p>
                <p class="font-medium">{{ number_format($subtotal, 2) }}</p>
            </div>
            <div class="flex justify-between">
                <p class="font-medium">Biaya Pengiriman:</p>
                <p class="font-medium">{{ number_format($shippingCost, 2) }}</p>
            </div>
            <div class="flex justify-between font-semibold text-xl">
                <p>Total:</p>
                <p>{{ number_format($total, 2) }}</p>
            </div>
        </div>

        <!-- Address Form -->
        <div class="mt-6 bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Alamat Pengiriman</h2>
            <form action="{{ route('complete.checkout') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="address" class="block text-sm font-medium text-gray-700">Alamat Pengiriman</label>
                    <input type="text" name="address" id="address" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md" value="{{ old('address') }}" required>
                    @error('address')
                        <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-6">
                    <button type="submit" class="px-6 py-3 w-full bg-green-600 text-white font-semibold rounded-md hover:bg-green-700 focus:outline-none">
                        Selesaikan Pembelian
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
