<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Keranjang Belanja
        </h2>
    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-500 text-white p-4 rounded-lg shadow mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr>
                                <th class="border-b py-2">Nama Produk</th>
                                <th class="border-b py-2">Jumlah</th>
                                <th class="border-b py-2">Total Harga</th>
                                <th class="border-b py-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($cartItems as $item)
                                <tr>
                                    <td class="border-b py-2">{{ $item->product->name }}</td>
                                    <td class="border-b py-2">
                                        <form action="{{ route('cart.update', $item->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="w-20 text-center" required>
                                            <button type="submit" class="ml-2 inline-flex items-center px-3 py-1 bg-blue-500 text-white font-semibold text-xs rounded-lg hover:bg-blue-700">
                                                <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 13l-7 7-7-7" />
                                                </svg>
                                                Edit
                                            </button>
                                        </form>
                                    </td>
                                    <td class="border-b py-2">Rp{{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                                    <td class="border-b py-2">
                                        <form action="{{ route('cart.destroy', $item->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800">
                                                <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-4 text-center">Keranjang kosong.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-4 text-right">
                <a href="{{ route('checkout.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-green-500 text-white font-semibold text-sm rounded-lg shadow hover:bg-green-700">
                    <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18l-2 13H5L3 3z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 21c0-1.104.895-2 2-2s2 .896 2 2H6zM14 21c0-1.104.895-2 2-2s2 .896 2 2h-4z" />
                    </svg>
                    Check Out
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
