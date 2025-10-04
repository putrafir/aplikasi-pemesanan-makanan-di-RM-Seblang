<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class KasirController extends Controller
{
    public function index(Request $request)
    {


            $query = Transaksi::query();

    if ($request->date) {
        $query->whereDate('created_at', $request->date);
    }

    if ($request->status) {
        $query->where('status', $request->status);
    }
    if ($request->status_bayar) {
        $query->where('status_bayar', $request->status_bayar);
    }

    $transaksis  = $query->get();

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
    $transaksi->status = 'dibayar';
    $transaksi->save();
    // Update status nomor meja jika ada
    if ($transaksi->nomor_meja) {
        $transaksi->nomor_meja->status = 'tersedia';
        $transaksi->nomor_meja->save();
    }



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

//     public function pesanLagi($id)
// {
//     // Ambil data transaksi lama kalau ingin auto-mengisi form
//     $transaksi = Transaksi::findOrFail($id);

//     // Jika ingin langsung ke form pemesanan baru (tanpa isi otomatis)
//     // return redirect()->route('kasir.pesanan')->with('success', 'Silakan lakukan pemesanan baru.');
//     return redirect()->route('customer.menu')
//                      ->with('success', 'Silakan pilih menu untuk pesan lagi.');

//     // Jika ingin isi otomatis sesuai pesanan sebelumnya:
//     // return view('kasir.form_pesanan', compact('transaksi'));
// }

public function pesanLagi($id, Request $request)
{
    $transaksi = Transaksi::findOrFail($id);

    // Simpan nomor_meja ke session customer
    //
    // simpan nomor meja ke session
    session(['nomor_meja' => $transaksi->nomor_meja]);

    // Arahkan customer langsung ke menu
    return redirect()->route('customer.menu')
                     ->with('success', 'Silakan pilih menu untuk pesan lagi di Meja ' . $transaksi->nomor_meja);
}





}
