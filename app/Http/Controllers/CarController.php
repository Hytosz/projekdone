<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // [cite: 1301]

class CarController extends Controller
{
    /**
     * 1. HALAMAN UTAMA (USER & PUBLIC)
     * Menampilkan daftar mobil dengan fitur PENCARIAN & PAGINATION (Max 6)
     */
    public function index(Request $request)
    {
        // Query dasar mengambil data terbaru [cite: 1158]
        $query = Car::latest();

        // Logika Pencarian: Jika ada input 'search'
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('brand', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%");
            });
        }

        // PAGINATION: Batasi 6 mobil per halaman [cite: 1159]
        $cars = $query->paginate(6);

        // Agar kata kunci pencarian tidak hilang saat pindah halaman
        if ($request->filled('search')) {
            $cars->appends(['search' => $request->search]);
        }

        return view('welcome', compact('cars'));
    }

    /**
     * 2. HALAMAN DETAIL
     */
    public function show($id)
    {
        $car = Car::findOrFail($id);
        return view('detail', compact('car'));
    }

    /**
     * 3. HALAMAN CREATE (ADMIN)
     */
    public function create()
    {
        return view('admin.create');
    }

    /**
     * 4. PROSES SIMPAN (ADMIN)
     */
    public function store(Request $request)
    {
        $request->validate([
            'brand' => 'required',
            'model' => 'required',
            'price' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Upload Gambar [cite: 1289]
        $imagePath = $request->file('image')->store('cars', 'public');

        Car::create([
            'brand' => $request->brand,
            'model' => $request->model,
            'price' => $request->price,
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        return redirect('/')->with('success', 'Mobil berhasil ditambahkan!');
    }

    /**
     * 5. HALAMAN EDIT (ADMIN)
     */
    public function edit($id)
    {
        $car = Car::findOrFail($id);
        return view('admin.edit', compact('car'));
    }

    /**
     * 6. PROSES UPDATE (ADMIN)
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'brand' => 'required',
            'model' => 'required',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $car = Car::findOrFail($id);

        $data = [
            'brand' => $request->brand,
            'model' => $request->model,
            'price' => $request->price,
            'description' => $request->description,
        ];

        // Cek ganti gambar [cite: 1354]
        if ($request->hasFile('image')) {
            if ($car->image && Storage::disk('public')->exists($car->image)) {
                Storage::disk('public')->delete($car->image);
            }
            $data['image'] = $request->file('image')->store('cars', 'public');
        }

        $car->update($data);

        return redirect()->route('home')->with('success', 'Data mobil berhasil diperbarui!');
    }

    /**
     * 7. PROSES HAPUS (ADMIN)
     */
    public function destroy($id)
    {
        $car = Car::findOrFail($id);

        // Hapus gambar fisik [cite: 1354]
        if ($car->image && Storage::disk('public')->exists($car->image)) {
            Storage::disk('public')->delete($car->image);
        }

        $car->delete();

        return redirect()->route('home')->with('success', 'Mobil berhasil dihapus!');
    }
}