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
        Schema::table('transaction_product', function (Blueprint $table) {
            $table->decimal('price', 10, 2)->default(0)->change();  // Set default value untuk kolom price
        });
    }

    public function down()
    {
        Schema::table('transaction_product', function (Blueprint $table) {
            $table->decimal('price', 10, 2)->change();  // Hapus default value jika rollback
        });
    }
};
