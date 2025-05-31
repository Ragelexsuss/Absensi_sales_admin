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
        Schema::create('t0lokasi', function (Blueprint $table) {
            $table->id();
            $table->integer('id_lokasi');
            $table->string('userSales');
            $table->string('userToko');
            $table->string('namaToko');
            $table->string('address');
            $table->integer('radius');
            $table->double('latitude');
            $table->double('longitude');
            $table->string('image_url');
            $table->boolean('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lokasis');
    }
};
