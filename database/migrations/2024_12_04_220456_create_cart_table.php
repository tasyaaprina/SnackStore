<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('cart', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id'); // ID pengguna
        $table->unsignedBigInteger('product_id'); // ID produk
        $table->integer('quantity'); // Jumlah produk
        $table->decimal('price', 10, 2); // Harga produk
        $table->timestamps();

        // Relasi dengan tabel users
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        // Relasi dengan tabel products
        $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart');
    }
};
