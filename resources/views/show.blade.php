<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $product->name }}
        </h2>
    </x-slot>
   
    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4">
                <!-- Tombol Kembali -->
                <a href="{{ url('dashboard') }}" class="inline-block bg-blue-500 text-white px-4 py-2 rounded-lg shadow hover:bg-gray-600">
                    <i class="fa fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>

            <!-- Pesan Sukses -->
            @if(session('success'))
                <div class="bg-green-500 text-white p-4 rounded-lg shadow mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Bagian Gambar -->
                    <div class="flex justify-center items-center">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full md:w-3/4 h-auto object-cover rounded-lg shadow-lg">
                    </div>
                    
                    <!-- Bagian Detail Produk -->
                    <div class="flex flex-col justify-between">
                        <div>
                            <h3 class="text-2xl font-bold mb-4">{{ $product->name }}</h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-2">
                                <span class="font-bold">Deskripsi:</span> {{ $product->description }}
                            </p>
                            <p class="text-gray-600 dark:text-gray-400 mb-2">
                                <span class="font-bold">Stok:</span> {{ $product->stock }}
                            </p>
                            <p class="text-gray-600 dark:text-gray-400 mb-2">
                                <span class="font-bold">Kategori:</span> {{ $product->category->name }}
                            </p>
                            <p class="text-gray-600 dark:text-gray-400 mb-2">
                                <span class="font-bold">Rasa:</span> {{ $product->rasa }}
                            </p>
                            <p class="text-gray-800 dark:text-gray-300 font-bold text-lg mb-4">
                                <span class="font-bold">Harga:</span> {{ $product->formatted_price }}
                            </p>
                        </div>
                        <form method="POST" action="{{ route('cekout.add', $product->id) }}">
                            @csrf
                            <div class="mb-4">
                                <label for="quantity" class="block text-gray-700 dark:text-gray-400 font-medium">Jumlah Pesan</label>
                                <input type="number" id="quantity" name="quantity" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-blue-200 dark:bg-gray-700 dark:text-white" min="1" max="{{ $product->stock }}" value="1" required>
                            </div>
                            <button type="submit" class="block bg-blue-500 text-white text-center font-bold text-lg px-6 py-3 rounded-lg shadow hover:bg-blue-600">
                                <i class="fa fa-shopping-cart mr-2"></i> Masukkan Keranjang
                            </button>
                        </form>                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
