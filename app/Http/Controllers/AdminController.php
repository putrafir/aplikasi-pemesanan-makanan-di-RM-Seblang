<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Category;
use App\Models\Transaksi;
use App\Models\Pesanan;
use App\Models\NomorMeja;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\PesananDetail;
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
        $categories = Category::all();
        return view('admin.tambahMenu', compact('menus', 'categories'));
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
        $categories = Category::all();
        return view('admin.editMenu', compact('menu', 'categories'));
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

    public function AdminLaporan(){
        return view('admin.laporan');
    }

   public function AdminSearchByDate(Request $request)
    {
        $tanggalAwal = Carbon::parse($request->tanggal_awal)->startOfDay();
        $tanggalAkhir = Carbon::parse($request->tanggal_akhir)->endOfDay();

        $transaksis = Transaksi::whereBetween('created_at', [$tanggalAwal, $tanggalAkhir])->get();
        $totalPendapatan = $transaksis->sum('total_bayar');

        return view('admin.search_by_date', compact('transaksis', 'tanggalAwal', 'tanggalAkhir', 'totalPendapatan'));


        return view('admin.search_by_date', compact('transaksis', 'tanggalAwal', 'tanggalAkhir', 'totalPendapatan'));
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

    public function KategoriMenu(){
     $kategori = Category::all();
        return view('admin.kategoriMenu', compact('kategori'));
    }
public function tambahKategori()
    {
        $kategori = Category::all();
        return view('admin.tambahKategori', compact('kategori'));
    }

    public function storeKategori(Request $request){

        $request->validate([
            'nama' => 'required|string|max:255|unique:categories,nama',
            ]);

            Category::create([
            'nama' => $request->nama,
            ]);

        $notification = array(
            'message' => 'Kategori berhasil ditambahkan',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.kategori.menu')->with($notification);

    }
    // End Method
    public function editKategori($id){
        $kategori  = Category::find($id);
        return view('admin.editKategori', compact('kategori'));
    }
     // End Method

     public function updateKategori(Request $request)
{
    $request->validate([
        'id' => 'required|exists:categories,id',
        'nama' => 'required|string|max:255',
    ]);

    Category::findOrFail($request->id)->update([
        'nama' => $request->nama,
    ]);

    return redirect()->route('admin.kategori.menu')->with([
        'message' => 'Kategori berhasil diperbarui',
        'alert-type' => 'success',
    ]);
}

 public function deleteKategori($id){
    $item = Category::findOrFail($id);
    $item->save();

    $item->delete();

    $notification = [
        'message' => 'Kategori berhasil dihapus',
        'alert-type' => 'success'
    ];

    return redirect()->back()->with($notification);
    }

    public function akunKasir()
    {
        $kasirs = DB::table('users')->where('role', 'kasir')->get();
        return view('admin.akunkasir', compact('kasirs'));
    }

    public function dashboard()
    {
        //Customer
        $todayCustomer = Transaksi::whereDate('created_at', Carbon::today())->count();
        $yesterdayCustomer = Transaksi::whereDate('created_at', Carbon::yesterday())->count();
        $customerChange = $this->calculatePercentage($todayCustomer, $yesterdayCustomer);

        //Order
        $todayMenu = 0;

        $transaksis = Transaksi::whereDate('created_at', Carbon::today())->get();

        foreach ($transaksis as $transaksi) {
            $details = json_decode($transaksi->details);

            foreach ($details as $item) {
                $todayMenu += $item->jumlah;
            }
        }
        $yesterdayMenu = 0;

        $transaksis = Transaksi::whereDate('created_at', Carbon::yesterday())->get();

        foreach ($transaksis as $transaksi) {
            $details = json_decode($transaksi->details);

            foreach ($details as $item) {
                $yesterdayMenu += $item->jumlah;
            }
        }
        $menuChange = $this->calculatePercentage($todayMenu, $yesterdayMenu);

        //Income
        $todayIncome = Transaksi::whereDate('created_at', Carbon::today())
                            ->where('status_bayar', 'sudah bayar')
                            ->sum('total_bayar');
        $yesterdayIncome = Transaksi::whereDate('created_at', Carbon::yesterday())
                    ->where('status_bayar', 'sudah bayar')
                    ->sum('total_bayar');

        $incomeChange = $this->calculatePercentage($todayIncome, $yesterdayIncome);

        // Income per bulan (total_bayar)
        $incomeDataRaw = Transaksi::selectRaw('MONTH(created_at) as month, SUM(total_bayar) as total')
        ->whereYear('created_at', Carbon::now()->year)
        ->where('status_bayar', 'sudah bayar')
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        $customerDataRaw = Transaksi::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
        ->whereYear('created_at', Carbon::now()->year)
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        // Buat array 12 bulan, default 0
        $incomeData = array_fill(0, 12, 0);

        // Masukkan data sesuai bulan
        foreach ($incomeDataRaw as $item) {
            // $item->month = 1..12, array index = 0..11
            $incomeData[$item->month - 1] = $item->total;
        }

        // Buat array 12 bulan, default 0
        $customerData = array_fill(0, 12, 0);

        // Masukkan data sesuai bulan
        foreach ($customerDataRaw as $item) {
            // $item->month = 1..12, array index = 0..11
            $customerData[$item->month - 1] = $item->total;
        }


        return view('admin.dashboard', compact('todayCustomer', 'customerChange', 'customerData', 'todayMenu', 'menuChange', 'todayIncome', 'incomeChange', 'incomeData'));
    }

    private function calculatePercentage($today, $yesterday)
    {
        if ($yesterday == 0) {
            return $today > 0 ? 100 : 0;
        }

        return (($today - $yesterday) / $yesterday) * 100;
    }
}
