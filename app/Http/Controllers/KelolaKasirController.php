<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class KelolaKasirController extends Controller
{
    // Menampilkan daftar kasir
    public function index()
    {
        $users = User::where('role', 'kasir')->get();
        return view('admin.kelola_kasir.index', compact('users'));
    }

    // Tambah kasir baru
    public function tambahKasir(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|in:kasir',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'password' => bcrypt($validated['password']),
        ]);

        return redirect()->back()->with('success', 'Kasir berhasil ditambahkan.');
    }

    // Update data kasir
    public function update(Request $request, $id)
    {
        $kasir = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
        ]);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => !empty($validated['password'])
                ? bcrypt($validated['password'])
                : $kasir->password,
        ];

        $kasir->update($data);

        return redirect()->route('admin.kelolakasir')
            ->with('success', 'Data kasir berhasil diperbarui.');
    }

    // Hapus data kasir
    public function delete($id)
    {
        $kasir = User::findOrFail($id);
        $kasir->delete();

        return redirect()->back()->with('success', 'Kasir berhasil dihapus.');
    }

    // public function update(Request $request, $id)
    // {
    //     $kasir = User::findOrFail($id);

    //     // Validasi input
    //     $validated = $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|string|email|max:255|unique:users,email,' . $id,
    //         'password' => 'nullable|string|min:8',
    //     ]);


    //     $password = empty($validated['password']) ? $kasir->password : bcrypt($validated['password']);

    //     $data = [
    //         'name' => $validated["name"] ?? $kasir->name,
    //         'email' => $validated["email"] ?? $kasir->email,
    //         'password' => $password,
    //     ];
    //     if ($kasir->update($data)) {
    //         return redirect()->route('admin.kelolakasir')
    //             ->with('success', 'Data kasir berhasil diperbarui.');
    //     }
    //     ;
    //     return redirect()->back()->with('success', 'Kasir gagal diperbarui.');
    // }

    // public function delete($id)
    // {
    //     $kasir = User::findOrFail($id);
    //     $kasir->delete();

    //     return redirect()->back()->with('success', 'Kasir berhasil dihapus.');
    // }

}
