<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class KasirController extends Controller
{
    public function index(Request $request)
    {

        $query = Transaksi::query();

        // TAB FILTER
        if ($request->tab === 'baru') {
            $query->where('status', 'aktif')
                ->where('status_bayar', 'belum bayar');
        }

        if ($request->tab === 'belum-bayar') {
            $query->where('status', 'nonaktif')
                ->where('status_bayar', 'belum bayar');
        }

        if ($request->tab === 'selesai') {
            $query->where('status', 'nonaktif')
                ->where('status_bayar', 'sudah bayar');
        }

        // FILTER TANGGAL (tetap jalan)
        if ($request->date) {
            $query->whereDate('created_at', $request->date);
        }

        $transaksis = $query->latest()->get();
        session()->forget(['from_kasir', 'nomor_meja']);
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
            'metode_pembayaran' => 'required|in:tunai,qris',
            'uang_dibayarkan' => 'required|numeric|min:0',
        ]);

    $transaksi = Transaksi::findOrFail($id);
    $transaksi->metode_pembayaran = $request->metode_pembayaran;
    $transaksi->uang_dibayarkan = $request->uang_dibayarkan;
    $transaksi->status = 'dibayar';
    $transaksi->waktu_bayar = now();
    $transaksi->kasir_id = auth()->id();
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
        $details = json_decode($pesanan->details, true);
        return view('kasir.detail', compact('pesanan', 'details'));
    }

    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->delete();

        return redirect()->route('kasir.pesanan')->with('success', 'Pesanan berhasil dihapus.');
    }

    public function pesanLagi($id, Request $request)
    {
        $transaksi = Transaksi::findOrFail($id);

        // Simpan nomor_meja ke session customer
        //
        // simpan nomor meja ke session
        session(['from_kasir' => true, 'nomor_meja' => $transaksi->nomor_meja]);

        // Arahkan customer langsung ke menu
        return redirect()->route('customer.menu')
                        ->with('success', 'Silakan pilih menu untuk pesan lagi di Meja ' . $transaksi->nomor_meja);
    }

    public function cetakStruk($id)
    {
        $pesanan = Transaksi::findOrFail($id);

        // 🔒 Proteksi: hanya boleh jika sudah bayar
        if ($pesanan->status_bayar !== 'sudah bayar') {
            abort(403, 'Pesanan belum dibayar');
        }

        $details = json_decode($pesanan->details, true);

        return view('kasir.struk', compact('pesanan', 'details'));
    }


    // public function update(Request $request, $id)
    // {
    //     $pesanan = Transaksi::findOrFail($id);

    //     $total = 0;

    //     foreach ($request->items as $itemId => $item) {
    //         $detail = Transaksi::where('pesanan_id', $id)
    //                     ->where('id', $itemId)
    //                     ->first();

    //         if ($detail) {
    //             $detail->jumlah = $item['jumlah'];
    //             $detail->catatan = $item['catatan'];
    //             $detail->subtotal = $detail->harga * $item['jumlah'];
    //             $detail->save();

    //             $total += $detail->subtotal;
    //         }
    //     }

    //     $pesanan->total_bayar = $total;
    //     $pesanan->save();

    //     return redirect()
    //         ->route('kasir.detail', $id)
    //         ->with('success', 'Pesanan berhasil diperbarui');
    // }

}
