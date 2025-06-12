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
        return view('customer.keranjang', compact('keranjangs', 'totalBayar', 'nomor_mejas'));
    }
    
    public function addToCart(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
        ]);

        $menu = Menu::findOrFail($request->menu_id);

        $sessionId = $request->session()->getId();

        $keranjang = Keranjang::where('menu_id', $request->menu_id)
            ->where('session_id', $sessionId)
            ->first();

        if ($keranjang) {
            $keranjang->jumlah += 1;
            $keranjang->total_harga = $keranjang->jumlah * $menu->harga;
            $keranjang->save();
        } else {
            Keranjang::create([
                'session_id' => $sessionId,
                'menu_id' => $request->menu_id,
                'harga_satuan' => $menu->harga,
                'jumlah' => 1,
                'total_harga' => $menu->harga,
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
        //     "nomor_meja"=>"unique:transaksis,nomor_meja,required",
        // ]);
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

        $transaksi = Transaksi::create([
            'total_bayar' => $totalBayar,
            'nomor_meja' => $request->nomor_meja,
            'session_id' => $sessionId,
            'details' => $details->toJson(),
        ]);

        // Update nomor meja menjadi tidak tersedia
        $nomorMeja = NomorMeja::where('nomor', $request->nomor_meja)->first();
        if ($nomorMeja) {
            $nomorMeja->status = 'terisi';
            $nomorMeja->save();
        }
     

        Keranjang::where('session_id', $sessionId)->delete();

        return redirect()->back()->with('success', "Pemesanan berhasil, silakan bayar nanti sebesar Rp. $totalBayar");
    }
}