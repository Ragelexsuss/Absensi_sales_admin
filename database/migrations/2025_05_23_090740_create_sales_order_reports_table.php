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
        Schema::create('t0sales_order_reports', function (Blueprint $table) {
            $table->id();
            $table->string('id_document');
            $table->string('idOrder');
            $table->float('total_amount');
            $table->float('total_items');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_order_reports');
    }
};
