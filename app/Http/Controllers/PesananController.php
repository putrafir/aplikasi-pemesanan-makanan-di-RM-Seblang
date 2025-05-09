<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;

class PesananController extends Controller
{
    public function index()
    {
        $pesanans = Pesanan::all(); // Menampilkan semua pesanan
        return view('kasir.pesanan', compact('pesanans'));
    }

    public function showBayar($id)
    {
        // Ambil pesanan beserta relasi items
        $pesanan = Pesanan::with('items')->findOrFail($id);

        // Cegah pembayaran jika status masih keranjang
        if ($pesanan->status === 'keranjang') {
            return redirect()->route('kasir.pesanan')->withErrors(['Pesanan masih dalam keranjang dan belum siap dibayar.']);
        }

        // Hitung total
        $total = $pesanan->total_harga;

        return view('kasir.bayar', compact('pesanan', 'total'));
    }

    public function prosesBayar(Request $request, $id)
    {
        $pesanan = Pesanan::findOrFail($id);

        // Cegah pembayaran jika status tidak valid
        if ($pesanan->status !== 'belum dibayar') {
            return redirect()->route('kasir.pesanan')->withErrors(['Pesanan ini tidak dapat dibayar.']);
        }

        // Validasi
        $request->validate([
            'jumlah_bayar' => 'required|numeric|min:' . $pesanan->total_harga,
            'metode_pembayaran' => 'required|in:tunai,qris',
        ]);

        // Update pesanan
        $pesanan->update([
            'status' => 'dibayar',
            'metode_pembayaran' => $request->metode_pembayaran,
        ]);

        return redirect()->route('kasir.pesanan')->with('success', 'Pembayaran berhasil diproses!');
    }

    public function konfirmasi($id)
    {
        $pesanan = Pesanan::findOrFail($id);

        // Hanya ubah status jika masih 'keranjang'
        if ($pesanan->status === 'keranjang') {
            $pesanan->update(['status' => 'belum dibayar']);
            return redirect()->back()->with('success', 'Pesanan telah dikonfirmasi dan siap dibayar.');
        }

        return redirect()->back()->withErrors(['Pesanan ini sudah dikonfirmasi sebelumnya.']);
    }

}
