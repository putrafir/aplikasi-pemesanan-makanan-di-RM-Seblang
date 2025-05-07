<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = ['nama', 'harga', 'jumlah', 'pesanan_id'];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }
}
