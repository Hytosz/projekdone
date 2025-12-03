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
    Schema::create('transactions', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // Pembeli
        $table->foreignId('car_id')->constrained()->cascadeOnDelete();  // Mobil yang dibeli
        $table->string('payment_proof'); // Foto bukti bayar
        $table->string('status')->default('pending'); // pending, processing, shipped, completed
        $table->integer('rating')->nullable(); // 1-5 Bintang (diisi nanti)
        $table->text('review')->nullable(); // Ulasan (diisi nanti)
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
