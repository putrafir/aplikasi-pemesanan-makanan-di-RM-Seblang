<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Category;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\Transaksi;
use App\Models\Pesanan;
use Carbon\Carbon;
use DateTime;
use Barryvdh\DomPDF\Facade\Pdf;


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

    public function AdminLaporan(){
           return view('admin.laporan');
    }

   public function AdminSearchByDate(Request $request)
{
    $tanggalAwal = Carbon::parse($request->tanggal_awal)->startOfDay();
    $tanggalAkhir = Carbon::parse($request->tanggal_akhir)->endOfDay();

    $transaksis = Transaksi::whereBetween('created_at', [$tanggalAwal, $tanggalAkhir])->get();

    return view('admin.search_by_date', compact('transaksis', 'tanggalAwal', 'tanggalAkhir'));
}

 public function detail($id)
    {
        $pesanan = Transaksi::with('details.menu')->findOrFail($id);
        $pesanan->details = json_decode($pesanan->details);
        return view('admin.detail', compact('pesanan'));
    }

public function AdminInvoiceDownload($id)
{
   $transaksi = Transaksi::findOrFail($id);
$details = json_decode($transaksi->details, true); // true = hasil array

// Pastikan hasilnya array
if (!is_array($details)) {
    abort(500, 'Format data details tidak valid.');
}

$totalPrice = 0;
foreach ($details as $item) {
    $totalPrice += $item['harga'] * $item['jumlah'];
}

$pdf = Pdf::loadView('admin.invoice_download', [
    'transaksi' => $transaksi,
    'details' => $details,
    'totalPrice' => $totalPrice,
])->setPaper('a4');

return $pdf->download('invoice.pdf');

}

}
