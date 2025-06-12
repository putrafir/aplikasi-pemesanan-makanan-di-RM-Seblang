<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Http\Requests\StorePesananRequest;
use App\Http\Requests\UpdatePesananRequest;
use Illuminate\Http\Request;
use App\Models\Transaksi;

class PesananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pesanans = Pesanan::with('items')->where('status', '!=', 'keranjang')->get();
        return view('kasir.pesanan', compact('pesanans'));
    }

    public function store(Request $request)
    {
        $pesanan = Pesanan::create([
            'status' => 'keranjang',
            // tambahkan field lain jika ada, seperti 'user_id' => auth()->id()
        ]);

        return redirect()->route('menu.index')->with('success', 'Pesanan baru telah dibuat.');
    }

    public function konfirmasi($id)
    {
        $pesanan = Pesanan::with('items')->findOrFail($id);

        if ($pesanan->status === 'keranjang') {
            if ($pesanan->items->isEmpty()) {
                return redirect()->back()->withErrors(['Pesanan tidak memiliki item.']);
            }

            $total = $pesanan->items->sum(function ($item) {
                return $item->harga * $item->jumlah;
            });

            $pesanan->update([
                'status' => 'belum bayar',
                'total' => $total
            ]);

            return redirect()->back()->with('success', 'Pesanan telah dikonfirmasi dan siap dibayar.');
        }

        return redirect()->back()->withErrors(['Pesanan ini sudah dikonfirmasi sebelumnya.']);
    }

     public function showBayar($id)
    {

        $transaksis = Transaksi::find($id);
        if ($transaksis->status_bayar == 'sudah bayar') {
            return redirect()->back()->with('error', 'Pesanan telah dibayar.');
        }

        $pesanan = json_decode($transaksis->details, true);
        return view('kasir.bayar_pesanan', compact('transaksis', 'pesanan'));
    }

    public function prosesBayar($id, Request $request)
    {
        $validate = $request->validate([
            'uang_dibayarkan' => ['required', 'numeric'],
            'metode_pembayaran' => ['required']
        ]);

        $pesanan = Transaksi::find($id);
        if (!$pesanan) {
            return redirect()->back()->with('error', 'Pesanan tidak ditemukan.');
        }
        if ($pesanan->status_bayar == 'sudah bayar') {
            return redirect()->back()->with('error', 'Pesanan telah dibayar.');
        }

        $transaksiDetail = json_decode($pesanan->details, true);
        $total = array_sum(array_column($transaksiDetail, 'subtotal'));
        ;
        if ($total > $validate['uang_dibayarkan']) {

            return redirect()->back()->with('error', 'Pesanan tidak ditemukan.');
        }

        $kembalian = $validate['uang_dibayarkan'] - $total;
        // Simpan ke tabel transaksi


        try {

            $pesanan->update([
                'uang_dibayarkan' => $validate['uang_dibayarkan'],
                'status_bayar' => 'sudah bayar',
                'metode_pembayaran' => $validate['metode_pembayaran'],
                'kembalian' => $kembalian,
            ]);

            // Update status nomor meja jika ada
            if ($pesanan->meja) {
                $pesanan->meja->status = 'tersedia';
                $pesanan->meja->save();
            }
            

            return redirect()->route('kasir.pesanan')->with('success', 'Pembayaran berhasil dilakukan.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Pesanan gagal.');

        }
    }
}
