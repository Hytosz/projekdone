<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishlist Saya</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10 font-sans">

    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">❤️ Wishlist Saya</h1>
        <a href="{{ route('home') }}" class="text-blue-600 hover:underline font-semibold">Kembali ke Home</a>
    </div>

    @if($wishlists->isEmpty())
        <div class="text-center py-20 bg-white rounded-lg shadow-sm">
            <p class="text-gray-500 text-xl">Belum ada mobil di wishlist Anda.</p>
            <a href="{{ route('home') }}" class="mt-4 inline-block bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">Cari Mobil</a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($wishlists as $car)
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition flex flex-col justify-between">
                
                <div class="relative h-48">
                    <img src="{{ Storage::url($car->image) }}" class="w-full h-full object-cover">
                    
                    {{-- Tombol Hapus Wishlist --}}
                    <form action="{{ route('wishlist.toggle', $car->id) }}" method="POST" class="absolute top-2 right-2">
                        @csrf
                        <button type="submit" class="bg-red-500 text-white p-2 rounded-full shadow hover:bg-red-600" title="Hapus dari Wishlist">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </form>
                </div>

                <div class="p-5">
                    <h2 class="text-xl font-bold text-gray-800">{{ $car->brand }} {{ $car->model }}</h2>
                    <p class="text-blue-600 font-bold mt-1 text-lg">Rp {{ number_format($car->price) }}</p>
                    <a href="{{ route('car.show', $car->id) }}" class="block mt-4 text-center bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">Lihat Detail</a>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</body>
</html>