<x-app-layout>
    <!-- Header -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Checkout
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Cart Items Table -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="w-full table-auto border-collapse">
                <thead>
                    <tr>
                        <th class="border-b border-gray-300 px-4 py-2 text-left">Nama Produk</th>
                        <th class="border-b border-gray-300 px-4 py-2 text-center">Jumlah</th>
                        <th class="border-b border-gray-300 px-4 py-2 text-right">Harga</th>
                        <th class="border-b border-gray-300 px-4 py-2 text-right">Total Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cartItems as $item)
                        <tr>
                            <td class="border-b border-gray-300 px-4 py-2">{{ $item->product->name }}</td>
                            <td class="border-b border-gray-300 px-4 py-2 text-center">{{ $item->quantity }}</td>
                            <td class="border-b border-gray-300 px-4 py-2 text-right">
                                Rp{{ number_format($item->product->price, 0, ',', '.') }}
                            </td>
                            <td class="border-b border-gray-300 px-4 py-2 text-right">
                                Rp{{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Order Summary -->
        <div class="mt-6 bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Ringkasan Pesanan</h2>
            <div class="flex justify-between mb-2">
                <p class="font-medium">Subtotal:</p>
                <p class="font-medium">Rp{{ number_format($subtotal, 0, ',', '.') }}</p>
            </div>
            <div class="flex justify-between mb-2">
                <p class="font-medium">Biaya Pengiriman:</p>
                <p class="font-medium">Rp{{ number_format($shippingCost, 0, ',', '.') }}</p>
            </div>
            <div class="flex justify-between font-semibold text-xl">
                <p>Total:</p>
                <p>Rp{{ number_format($total, 0, ',', '.') }}</p>
            </div>
        </div>

        <!-- Address and Payment Form -->
        <div class="mt-6 bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Informasi Pengiriman dan Pembayaran</h2>
            <form action="{{ route('complete.checkout') }}" method="POST">
                @csrf

                <!-- Alamat Pengiriman -->
                <div class="mb-4">
                    <label for="address" class="block text-sm font-medium text-gray-700">Alamat Pengiriman</label>
                    <input 
                        type="text" 
                        name="address" 
                        id="address" 
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md" 
                        value="{{ old('address') }}" 
                        required>
                    @error('address')
                        <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Metode Pembayaran -->
                <div class="mb-4">
                    <label for="payment_method" class="block text-sm font-medium text-gray-700">Metode Pembayaran</label>
                    <select 
                        name="payment_method" 
                        id="payment_method" 
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md" 
                        required>
                        <option value="cod">Cash On Delivery (COD)</option>
                        <option value="bank_transfer">Transfer Bank</option>
                        <option value="credit_card">Kartu Kredit</option>
                    </select>
                    @error('payment_method')
                        <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tombol Submit -->
                <div class="mt-6">
                    <button 
                        type="submit" 
                        class="px-6 py-3 w-full bg-green-600 text-white font-semibold rounded-md hover:bg-green-700 focus:outline-none">
                        Buat Pesanan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
