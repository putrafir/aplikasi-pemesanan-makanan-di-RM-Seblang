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
    public function updateStatusPesanan($id)
    {
        try {
            $transaksis = Transaksi::find($id);
            $data = $transaksis->status == 'belum diantar' ? 'sudah diantar' : 'belum diantar';
            $transaksis->status = $data;
            $transaksis->save();
            return redirect()->back()->with('success','status berhasil diubah');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error','status gagal diubah');
        }
    }
    public function prosesBayar(Request $request, $id)
    {
        // Validasi
        $request->validate([
            'metode' => 'required|in:tunai,qris',
            'jumlah_uang' => 'required|numeric|min:0',
        ]);

        $transaksi = Transaksi::findOrFail($id);
        $transaksi->metode_pembayaran = $request->metode;
        $transaksi->jumlah_uang = $request->jumlah_uang;
        $transaksi->status_bayar = 'lunas';
        $transaksi->status = 'belum diantar';
        $transaksi->save();

        return redirect()->back()->with('success', 'Pembayaran berhasil diproses.');
    }

    public function detail($id)
    {
        $pesanan = Transaksi::with('details.menu')->findOrFail($id);
        $pesanan->details = json_decode($pesanan->details);
        return view('kasir.detail', compact('pesanan'));
    }

    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->delete();

        return redirect()->route('kasir.pesanan')->with('success', 'Pesanan berhasil dihapus.');
    }
}
