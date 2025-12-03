<!DOCTYPE html>
<html>
<head>
    <title>Tambah Mobil</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">
    <div class="max-w-lg mx-auto bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-6">Tambah Data Mobil</h1>
        
        {{-- [cite: 1089] Enctype multipart wajib untuk upload file --}}
        <form action="{{ route('car.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <input type="text" name="brand" placeholder="Merk (Toyota)" class="w-full border p-2 rounded" required>
            <input type="text" name="model" placeholder="Model (Avanza)" class="w-full border p-2 rounded" required>
            <input type="number" name="price" placeholder="Harga" class="w-full border p-2 rounded" required>
            <textarea name="description" placeholder="Deskripsi" class="w-full border p-2 rounded"></textarea>
            
            <label class="block">Upload Gambar:</label>
            <input type="file" name="image" class="w-full border p-2 rounded" required>
            
            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded">Simpan Data</button>
        </form>
    </div>
</body>
</html>