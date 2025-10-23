<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMenuRequest;
use App\Http\Requests\UpdateMenuRequest;
use App\Models\Category;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // public function index(Request $request)
    // {
    //     $kategori = $request->query('kategori');

    //     $kategoris = Category::with(['menus' => function ($query) use ($kategori) {
    //         if ($kategori) {
    //             $query->where('kategori_id', function ($q) use ($kategori) {
    //                 $q->select('id')->from('categories')->where('nama', $kategori);
    //             });
    //         }
    //     }])->get();

    //     return view('home', compact('kategoris'));
    // }

    public function index(Request $request)
{
    $kategori = $request->query('kategori');

    $kategoris = Category::with(['menus' => function ($query) use ($kategori) {
        if ($kategori) {
            $query->where('kategori_id', function ($q) use ($kategori) {
                $q->select('id')->from('categories')->where('nama', $kategori);
            });
        }
    }])->get();

        $nomorMeja = $request->session()->get('nomor_meja');

        return view('home', compact('kategoris', 'nomorMeja'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMenuRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $menu = Menu::with('kategori')->findOrFail($id);

        // Tentukan placeholder sesuai kategori
        switch (strtolower($menu->kategori->nama)) {
            case 'makanan':
                $placeholder = 'Contoh: Sedikit pedas';
                break;
            case 'minuman':
                $placeholder = 'Contoh: Sedikit gula';
                break;
            case 'camilan':
                $placeholder = 'Contoh: Tambahkan coklat';
                break;
            default:
                $placeholder = 'Contoh: Tambahkan catatan sesuai selera';
                break;
        }
        return view('customer.menu-detail', compact('menu', 'placeholder'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMenuRequest $request, Menu $menu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        //
    }
}
