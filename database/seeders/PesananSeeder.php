<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pesanan;
use App\Models\Item;

class PesananSeeder extends Seeder
{
    public function run()
    {
        // Buat 5 pesanan contoh
        for ($i = 1; $i <= 5; $i++) {
            // Data item untuk setiap pesanan
            $items = [
                [
                    'nama' => 'Makanan ' . $i,
                    'harga' => rand(10000, 30000),
                    'jumlah' => rand(1, 3)
                ],
                [
                    'nama' => 'Minuman ' . $i,
                    'harga' => rand(5000, 15000),
                    'jumlah' => rand(1, 2)
                ]
            ];

            // Hitung total harga pesanan dari semua item
            $total = collect($items)->sum(function ($item) {
                return $item['harga'] * $item['jumlah'];
            });

            // Buat pesanan utama
            $pesanan = Pesanan::create([
                'nama_pelanggan' => 'Pelanggan ' . $i,
                'nomor_meja' => 'Meja ' . $i,
                'total_harga' => $total,
                'status' => 'belum dibayar',
                'metode_pembayaran' => null, // akan diisi saat pembayaran
            ]);

            // Simpan semua item ke tabel terkait dengan pesanan
            $pesanan->items()->createMany($items);
        }
    }
}
