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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Foreign key untuk produk
            $table->integer('quantity'); // Jumlah produk
            $table->decimal('total_price', 10, 2); // Harga total transaksi
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
