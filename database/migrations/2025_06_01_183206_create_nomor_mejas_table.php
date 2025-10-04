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
        // Schema::create('nomor_mejas', function (Blueprint $table) {
        //     $table->id();
        //     $table->integer('nomor')->unique();
        //     $table->enum('status', ['tersedia', 'terisi', 'reservasi', 'rusak'])->default('tersedia');
        //     $table->timestamps();
        // }); sementara

        Schema::create('pesanans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nomor_meja_id')->nullable()->constrained('nomor_mejas')->onDelete('set null');
            $table->enum('status', ['belum dibayar', 'dibayar', 'keranjang'])->default('belum dibayar');
            $table->decimal('total_harga', 10, 2);
            $table->string('metode_pembayaran')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nomor_mejas');
    }
};
