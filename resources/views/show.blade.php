<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $product->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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
                                <span class="font-bold">Kategori:</span> {{ $product->category_id }}
                            </p>
                            <p class="text-gray-800 dark:text-gray-300 font-bold text-lg mb-4">
                                <span class="font-bold">Harga:</span> {{ $product->formatted_price }}
                            </p>
                        </div>
                        
                        <!-- Tombol Pesan -->
                        <div class="mt-6">
                            <a href="#" class="block bg-blue-500 text-white text-center font-bold text-lg px-6 py-3 rounded-lg shadow hover:bg-blue-600">
                                <i class="fa fa-shopping-cart mr-2"></i> Pesan Sekarang
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
