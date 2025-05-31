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
        Schema::create('t0sales_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->unique();
            $table->integer('idLokasi');
            $table->string('user_id');
            $table->integer('total_harga');
            $table->integer('total_item');
            $table->json('order_data');
            $table->date('order_date');
            $table->boolean('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_orders');
    }
};
