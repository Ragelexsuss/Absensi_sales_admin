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
        Schema::create('t0akunSales', function (Blueprint $table) {
            $table->id();
            $table->string('id_sales');
            $table->string('email')->unique();
            $table->string('alamat');
            $table->string('kota');
            $table->string('namaPanjang');
            $table->string('noTelepon');
            $table->boolean('status');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
