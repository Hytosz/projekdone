<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    // 1. LIHAT DAFTAR WISHLIST USER
    public function index()
    {
        // Ambil mobil yang ada di wishlist user yang sedang login
        $wishlists = Auth::user()->wishlist()->latest()->get();
        return view('wishlist', compact('wishlists'));
    }

    // 2. TAMBAH / HAPUS WISHLIST (TOGGLE)
    public function toggle($id)
    {
        $user = Auth::user();
        
        // Cek apakah mobil sudah ada di wishlist user
        // toggle() otomatis menambah jika belum ada, atau menghapus jika sudah ada
        $user->wishlist()->toggle($id);

        return back()->with('success', 'Daftar wishlist berhasil diperbarui!');
    }
}