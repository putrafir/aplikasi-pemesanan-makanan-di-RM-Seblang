<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKeranjangRequest;
use App\Http\Requests\UpdateKeranjangRequest;
use App\Models\Keranjang;
use App\Models\Menu;
use App\Models\Transaksi;
use App\Models\NomorMeja;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;

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
            'catatan' => 'nullable|string|max:255',
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
            $keranjang->catatan = $request->catatan ?? $keranjang->catatan;
            $keranjang->save();
        } else {
            Keranjang::create([
                'session_id' => $sessionId,
                'menu_id' => $request->menu_id,
                'harga_satuan' => $menu->harga,
                'jumlah' => $jumlah,
                'total_harga' => $menu->harga * $jumlah,
                'catatan' => $request->catatan,
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





        // $request->validate([
        //     'nomor_meja' => 'nullable|string|max:10',
        //     'nomor_meja_manual' => 'nullable|string|max:10',
        // ]);

        if ($keranjangs->isEmpty()) {
            return redirect()->back()->with('error', 'Keranjang kosong, tidak ada yang bisa dibayar.');
        }

        if (auth()->check() && auth()->user()->role == 'kasir') {
            $request->validate([
                'nomor_meja' => 'nullable|string|max:10',
                'nomor_meja_manual' => 'nullable|string|max:10',
            ]);
            $nomorMejaInput = $request->nomor_meja_manual ?: $request->nomor_meja;
        } else {
            $request->validate([
                'nomor_meja' => 'required|exists:nomor_mejas,nomor',
            ]);
            $nomorMejaInput = $request->nomor_meja;
        }

        if (!$nomorMejaInput) {
            return redirect()->back()->with('error', 'Nomor meja wajib diisi.');
        }



}

