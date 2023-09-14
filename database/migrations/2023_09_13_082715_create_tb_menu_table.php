<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tb_menu', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('id_jenis_product')->constrained('tb_jenis_product');
            $table->string('nama_menu');
            $table->integer('stok');
            $table->integer('harga');
            $table->string('gambar_menu');
            $table->text('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_menu');
    }
};
