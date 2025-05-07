<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Jalankan migrasi untuk membuat tabel items.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->decimal('harga', 10, 2);
            $table->integer('jumlah');
            $table->foreignId('pesanan_id')->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('items');
    }
}
