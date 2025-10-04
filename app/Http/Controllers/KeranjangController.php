<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKeranjangRequest;
use App\Http\Requests\UpdateKeranjangRequest;
use App\Models\Keranjang;
use App\Models\Menu;
use App\Models\Transaksi;
use App\Models\NomorMeja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{

    public function index(Request $request)
    {
        $sessionId = $request->session()->getId();
        $nomor_mejas = NomorMeja::where('status', 'tersedia')->orderBy('nomor')->get();
        $keranjangs = Keranjang::where('session_id', $sessionId)->with('menu')->get();
        $totalBayar = $keranjangs->sum('total_harga');

        // Tambahan untuk popup detail
        $pesanan = Transaksi::where('session_id', $sessionId)
            ->orderBy('created_at', 'desc')
            ->first();

        return view('customer.keranjang', compact('keranjangs', 'totalBayar', 'nomor_mejas', 'pesanan'));
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'quantity' => 'nullable|integer|min:1',
        ]);

        $menu = Menu::findOrFail($request->menu_id);

        $sessionId = $request->session()->getId();

        // ambil quantity dari request, default = 1
        $jumlah = $request->input('quantity', 1);

        $keranjang = Keranjang::where('menu_id', $request->menu_id)
            ->where('session_id', $sessionId)
            ->first();

        if ($keranjang) {
            $keranjang->jumlah += $jumlah;
            $keranjang->total_harga = $keranjang->jumlah * $menu->harga;
            $keranjang->save();
        } else {
            Keranjang::create([
                'session_id' => $sessionId,
                'menu_id' => $request->menu_id,
                'harga_satuan' => $menu->harga,
                'jumlah' => $jumlah,
                'total_harga' => $menu->harga * $jumlah,
            ]);
        }

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function destroy($id)
    {
        $keranjang = Keranjang::findOrFail($id);
        $keranjang->delete();

        return redirect()->back()->with('success', 'Produk berhasil dihapus dari keranjang.');
    }

 public function checkout(Request $request)
{
    $sessionId = $request->session()->getId();
    $keranjangs = Keranjang::where('session_id', $sessionId)->get();

    if ($keranjangs->isEmpty()) {
        return redirect()->back()->with('error', 'Keranjang kosong, tidak ada yang bisa dibayar.');
    }

    $totalBayar = $keranjangs->sum('total_harga');

    $details = $keranjangs->map(function ($keranjang) {
        return [
            'menu_id' => $keranjang->menu_id,
            'nama' => $keranjang->menu->nama,
            'jumlah' => $keranjang->jumlah,
            'harga' => $keranjang->harga_satuan,
            'subtotal' => $keranjang->total_harga,
        ];
    });

    // pakai nomor meja dari session jika ada
    $nomorMeja = $request->session()->get('nomor_meja', $request->nomor_meja);

    $transaksi = Transaksi::create([
        'total_bayar' => $totalBayar,
        'nomor_meja' => $nomorMeja,
        'session_id' => $sessionId,
        'details' => $details->toJson(),
        'status' => 'aktif',
        'status_bayar' => 'belum bayar',
    ]);

    // Update status meja
    $nomorMejaModel = NomorMeja::where('nomor', $nomorMeja)->first();
    if ($nomorMejaModel) {
        $nomorMejaModel->status = 'terisi';
        $nomorMejaModel->save();
    }

    // Simpan nomor_meja ke session
    $request->session()->put('nomor_meja', $nomorMeja);

    Keranjang::where('session_id', $sessionId)->delete();

    // redirect langsung ke detail pesanan + notifikasi sukses
    return redirect()
        ->route('customer.detailPesanan', $transaksi->id)
        ->with('success', "Pemesanan berhasil, silakan bayar nanti sebesar Rp. $totalBayar");
}

public function detailPesanan($id)
{
    $pesanan = Transaksi::findOrFail($id);

    return view('customer.detailpesanan', compact('pesanan'));
}




    public function update(Request $request, $id)
    {
        $keranjang = Keranjang::findOrFail($id);

        // aksi sesuai tombol
        if ($request->action === 'increment') {
            $keranjang->jumlah += 1;
        } elseif ($request->action === 'decrement' && $keranjang->jumlah > 1) {
            $keranjang->jumlah -= 1;
        } else {
            $keranjang->jumlah = $request->jumlah; // fallback jika user langsung edit input
        }

        // update total harga
        $keranjang->total_harga = $keranjang->jumlah * $keranjang->harga_satuan;
        $keranjang->save();

        return back()->with('success', 'Jumlah keranjang berhasil diperbarui.');
    }

// public function pesanLagi(Request $request)
// {
//     $nomorMeja = $request->session()->get('nomor_meja');

//     if (!$nomorMeja) {
//         $notification = [
//             'message' => 'Silakan masukkan nomor meja.',
//             'alert-type' => 'error'
//         ];

//         return redirect()->route('customer.nomormeja.form')->with($notification);
//     }

//     $notification = [
//         'message' => 'Silakan pesan lagi untuk Meja ' . $nomorMeja,
//         'alert-type' => 'success'
//     ];

//     return redirect()->route('customer.menu')->with($notification);
// }

public function riwayatPesanan($nomor_meja)
{
    $riwayat = Transaksi::where('nomor_meja', $nomor_meja)
        ->where('status', 'aktif')
        ->where('status_bayar', 'belum bayar')
        ->orderBy('created_at', 'desc')
        ->get();

    // Hitung total semua transaksi aktif & belum bayar
    $grandTotal = $riwayat->sum('total_bayar');

    return view('customer.riwayatPesanan', compact('riwayat', 'nomor_meja', 'grandTotal'));
}



}
