<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class KelolaKasirController extends Controller
{
    public function index()
    {
        return view('admin.kelola_kasir.index');
    }

   public function tambahKasir(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'role' => 'required|in:kasir', // Fix di sini
        'password' => 'required|string|min:8',
    ]);

    // Simpan user
    User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'role' => $validated['role'],
        'password' => bcrypt($validated['password']),
    ]);

    return redirect()->back()->with('success', 'Kasir berhasil ditambahkan.');
}

}
