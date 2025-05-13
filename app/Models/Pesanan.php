<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_pelanggan',
        'nomor_meja',
        'status',
        'metode_pembayaran',
        'total_harga'
    ];

    // Relasi: Pesanan memiliki banyak item
    public function items()
    {
        return $this->hasMany(Item::class);
    }

    // Accessor untuk menghitung total harga otomatis
    public function getTotalHargaAttribute()
    {
        return $this->items->sum(function ($item) {
            return $item->harga * $item->jumlah;
        });
    }

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }

    public function details()
    {
        return $this->hasMany(PesananDetail::class, 'pesanan_id', 'id');
    }
}