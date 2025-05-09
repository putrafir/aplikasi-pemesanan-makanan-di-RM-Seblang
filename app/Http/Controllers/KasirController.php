<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class KasirController extends Controller
{
    public function index()
    {

        $transaksis = Transaksi::all();
        return view('kasir.pesanan', compact('transaksis'));
    }
}
