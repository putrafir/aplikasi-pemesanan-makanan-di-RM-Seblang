<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }

    public function details()
    {
        return $this->hasMany(PesananDetail::class, 'pesanan_id', 'id');
    }
}
