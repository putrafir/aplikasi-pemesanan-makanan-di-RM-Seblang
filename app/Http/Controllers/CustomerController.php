<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function riwayat(Request $request)
    {
        $sessionId = $request->session()->getId();
        $pesanan = Transaksi::where('session_id', $sessionId)->orderBy('created_at','desc')->first();
        return view('customer.riwayat', compact('pesanan'));
    }
}
