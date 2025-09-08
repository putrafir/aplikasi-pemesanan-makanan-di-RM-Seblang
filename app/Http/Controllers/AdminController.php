<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Category;
use App\Models\NomorMeja;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;



class AdminController extends Controller
{
    public function index()
    {
        $menus = Menu::all();
        return view('admin.menu', compact('menus'));
    }

    public function tambahMenu()
    {
        $menus = Menu::all();
        return view('admin.tambahMenu', compact('menus'));
    }

    public function storeMenu(Request $request){

        $request->validate([
            'nama_menu' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'kategori' => 'required|exists:categories,id',
            //'stok' => 'required|in:habis,tersedia',
            ]);

        if ($request->file('image')) {
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(300,300)->save(public_path('upload/menu/'.$name_gen));
            $save_url = 'upload/menu/'.$name_gen;

            Menu::create([
                'nama' => $request->nama_menu,
                'gambar' => $save_url,
                'deskripsi' => $request->deskripsi,
                'harga' => $request->harga,
                'kategori_id' => $request->kategori,
            //    'stok' => $request->stok,
            ]);


        }

        $notification = array(
            'message' => 'Menu berhasil ditambahkan',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.menu')->with($notification);

    }
    // End Method

   public function editMenu($id){
        $menu = Menu::find($id);
        return view('admin.editMenu', compact('menu'));
    }
     // End Method

     public function updateMenu(Request $request){

        $menu_id = $request->id;

        if ($request->file('image')) {
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(300,300)->save(public_path('upload/menu/'.$name_gen));
            $save_url = 'upload/menu/'.$name_gen;

            Menu::find($menu_id)->update([
                'nama' => $request->nama_menu,
                'gambar' => $save_url,
                'deskripsi' => $request->deskripsi,
                'harga' => $request->harga,
                'kategori_id' => $request->kategori,
            //    'stok' => $request->stok,
            ]);
            $notification = array(
                'message' => 'Menu Updated Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('admin.menu')->with($notification);

        } else {

            Menu::find($menu_id)->update([
                'nama' => $request->nama_menu,
                'deskripsi' => $request->deskripsi,
                'harga' => $request->harga,
                'kategori_id' => $request->kategori,
            //    'stok' => $request->stok,

            ]);
            $notification = array(
                'message' => 'Menu Updated Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('admin.menu')->with($notification);

        }

    }
    // End Method

     public function deleteMenu($id){
        $item = Menu::find($id);
        $imgPath = public_path($item->gambar);

    if (file_exists($imgPath)) {
        unlink($imgPath);
    }

    $item->delete();

        $notification = array(
            'message' => 'Menu Delete Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    }
    // End Method

    public function updateStok(Request $request, $id)
    {
        $request->validate([
            'stok_baru' => 'required|in:habis,tersedia',
        ]);
        $menu = Menu::findOrFail($id);
        $menu->stok = $request->stok_baru;
        $menu->save();

        $notification = array(
            'message' => 'Stok menu berhasil diperbarui',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function nomorMeja()
    {
        $nomor_mejas = NomorMeja::all();
        return view('admin.nomormeja', compact('nomor_mejas'));
    }

    public function tambahNomorMeja()
    {
        $nomor_mejas = NomorMeja::all();
        return view('admin.tambahNomormeja', compact('nomor_mejas'));
    }

    public function storeNomorMeja(Request $request){

        $request->validate([
            'nomor' => 'required|integer|min:1|unique:nomor_mejas,nomor',
            'status' => 'required|in:tersedia,terisi,reservasi,rusak',
        ]);

        // Cek apakah nomor meja sudah ada
        $existingMeja = NomorMeja::where('nomor', $request->nomor)->first();
        if ($existingMeja) {
            $notification = array(
                'message' => 'Nomor meja sudah ada',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
        // Jika belum ada, simpan nomor meja baru
        if ($request->status == 'tersedia') {
            NomorMeja::create([
                'nomor' => $request->nomor,
                'status' => 'tersedia',
            ]);
        } else {
            NomorMeja::create([
                'nomor' => $request->nomor,
                'status' => $request->status,
            ]);
        }

        $notification = array(
            'message' => 'Nomor meja berhasil ditambahkan',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.nomormeja')->with($notification);

    }
    // End Method

    public function editNomorMeja($id){
        $nomor_meja = NomorMeja::find($id);
        return view('admin.editNomormeja', compact('nomor_meja'));
    }

    public function updateNomorMeja(Request $request){

        $nomor_meja_id = $request->id;

            NomorMeja::find($nomor_meja_id)->update([
                'nomor' => $request->nomor,
                'status' => $request->status,
            ]);

            $notification = array(
                'message' => 'Nomor Meja Updated Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('admin.nomormeja')->with($notification);

    }

    public function deleteNomorMeja($id){
        $item = NomorMeja::find($id);
        
    $item->delete();

        $notification = array(
            'message' => 'Nomor Meja Delete Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    }
}