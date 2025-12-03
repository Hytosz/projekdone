<!DOCTYPE html>
<html>
<head>
    <title>Edit Mobil</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">
    <div class="max-w-lg mx-auto bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-6">Edit Data Mobil</h1>
        
        <form action="{{ route('car.update', $car->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT') {{-- Wajib untuk proses Update di Laravel --}}

            <div>
                <label>Merk</label>
                <input type="text" name="brand" value="{{ $car->brand }}" class="w-full border p-2 rounded" required>
            </div>
            <div>
                <label>Model</label>
                <input type="text" name="model" value="{{ $car->model }}" class="w-full border p-2 rounded" required>
            </div>
            <div>
                <label>Harga</label>
                <input type="number" name="price" value="{{ $car->price }}" class="w-full border p-2 rounded" required>
            </div>
            <div>
                <label>Deskripsi</label>
                <textarea name="description" class="w-full border p-2 rounded">{{ $car->description }}</textarea>
            </div>
            
            <div>
                <label class="block mb-1">Ganti Gambar (Opsional):</label>
                <input type="file" name="image" class="w-full border p-2 rounded">
                <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengganti gambar.</p>
            </div>
            
            <div class="flex gap-2">
                <a href="{{ route('home') }}" class="w-1/2 text-center border border-gray-300 py-2 rounded">Batal</a>
                <button type="submit" class="w-1/2 bg-blue-600 text-white py-2 rounded">Update Data</button>
            </div>
        </form>
    </div>
</body>
</html>