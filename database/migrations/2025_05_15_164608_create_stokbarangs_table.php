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
        Schema::create('t0stokbarang', function (Blueprint $table) {
            $table->id();
            $table->string('idbarang');
            $table->string('id_gudang');
            $table->string('nama_barang');
            $table->integer('harga');
            $table->string('harga_format');
            $table->integer('jumlah_per_box');
            $table->integer('stok_barang');
            $table->boolean('status');
            $table->string('kategori');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stokbarangs');
    }
};
