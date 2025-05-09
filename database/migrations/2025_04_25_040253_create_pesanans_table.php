<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePesanansTable extends Migration
{
    /**
     * Jalankan migrasi untuk membuat tabel pesanans.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pesanans', function (Blueprint $table) {

            $table->id();
            $table->string('nama_pelanggan');
            $table->decimal('total_harga', 10, 2)->nullable(); // Menambahkan kolom total_harga
            $table->string('status')->default('belum dibayar');
            $table->string('nomor_meja')->nullable();
            $table->string('metode_pembayaran')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Pembatalan migrasi.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pesanans');
    }
}
