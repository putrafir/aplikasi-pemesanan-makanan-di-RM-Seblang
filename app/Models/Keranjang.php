<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    /** @use HasFactory<\Database\Factories\KeranjangFactory> */
    use HasFactory;

    protected $guarded = [];


    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
