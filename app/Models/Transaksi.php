<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany; // Karena satu transaksi bisa punya banyak detail

class Transaksi extends Model
{
    use HasFactory;
protected $guarded = [];

    /**
     * Get all of the details for the transaksi.
     */
    public function details(): HasMany
    {
        return $this->hasMany(PesananDetail::class, 'pesanan_id', 'id');
        // 'PesananDetail::class': Nama model untuk detail pesanan
        // 'pesanan_id': Foreign key di tabel 'pesanan_details' yang terhubung ke 'id' di tabel 'pesanans' (atau 'transaksis' jika nama tabel transaksi Anda 'transaksis')
        // 'id': Primary key di tabel 'transaksis' (atau 'pesanans')
    }
}
