<!DOCTYPE html>
<html>
<head>
    <title>Detail Mobil - {{ $car->brand }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10 min-h-screen flex items-center justify-center">
    <div class="max-w-4xl w-full bg-white p-8 rounded-lg shadow-lg flex flex-col md:flex-row gap-8">
        {{-- Gambar Mobil --}}
        <div class="w-full md:w-1/2">
            <img src="{{ Storage::url($car->image) }}" class="w-full h-auto rounded-lg shadow-md object-cover">
        </div>

        {{-- Info Mobil --}}
        <div class="w-full md:w-1/2 flex flex-col justify-center">
            <h1 class="text-4xl font-bold text-gray-800 mb-2">{{ $car->brand }}</h1>
            <h2 class="text-2xl font-semibold text-gray-600 mb-4">{{ $car->model }}</h2>
            
            <div class="text-3xl font-bold text-blue-600 mb-6">
                Rp {{ number_format($car->price, 0, ',', '.') }}
            </div>

            <h3 class="text-lg font-semibold border-b pb-2 mb-2">Deskripsi</h3>
            <p class="text-gray-700 leading-relaxed mb-8">
                {{ $car->description ?: 'Tidak ada deskripsi tersedia.' }}
            </p>

            <div class="flex gap-4">
                <a href="{{ route('home') }}" class="px-6 py-2 border border-blue-500 text-blue-500 rounded hover:bg-blue-50 transition">
                    &larr; Kembali
                </a>

                {{-- TOMBOL BELI (Hanya untuk User Biasa, Bukan Admin) --}}
                @auth
                    @if(Auth::user()->role == 'user') 
                        <a href="{{ route('checkout', $car->id) }}" class="px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition shadow-lg">
                            Beli Sekarang 🛒
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="px-6 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition">
                        Login untuk Membeli
                    </a>
                @endauth
            </div>
        </div>
    </div>
</body>
</html>