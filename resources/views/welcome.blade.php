<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Showroom Mobil</title>
    {{-- Menggunakan Tailwind CSS dari CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6 md:p-10 font-sans">

    {{-- 1. PESAN SUKSES --}}
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 shadow-md" role="alert">
            <p class="font-bold">Berhasil!</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    {{-- 2. HEADER / NAVIGASI --}}
    <div class="flex flex-col md:flex-row justify-between items-center mb-8 bg-white p-4 rounded-lg shadow-md">
        <h1 class="text-3xl font-extrabold text-gray-800 tracking-tight">Showroom Mobil</h1>
        
        @if (Route::has('login'))
            <div class="mt-4 md:mt-0 flex items-center gap-4">
                @auth
                    {{-- TAMPILAN KHUSUS ADMIN --}}
                    @if(Auth::user()->role == 'admin')
                        <div class="flex items-center gap-3">
                            <span class="text-gray-600 font-semibold hidden md:block">Halo, Admin!</span>
                            
                            <a href="{{ route('admin.transactions') }}" class="text-blue-600 hover:text-blue-800 font-medium hover:underline transition">
                                📄 Pesanan
                            </a>
                            
                            <a href="{{ route('car.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition shadow-sm font-medium">
                                + Tambah Mobil
                            </a>
                        </div>

                    {{-- TAMPILAN KHUSUS USER BIASA --}}
                    @else
                        <span class="text-gray-600 hidden md:block">Halo, {{ Auth::user()->name }}!</span>
                        
                        {{-- Menu Wishlist Baru --}}
                        <a href="{{ route('wishlist.index') }}" class="text-red-500 hover:text-red-700 font-semibold hover:underline flex items-center gap-1 transition">
                            ❤️ Wishlist
                        </a>

                        <a href="{{ route('history') }}" class="text-blue-600 hover:text-blue-800 font-semibold hover:underline flex items-center gap-1 transition">
                            🛍️ Riwayat
                        </a>
                    @endif
                    
                    {{-- TOMBOL LOGOUT --}}
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-red-500 border border-red-500 px-3 py-1.5 rounded-md hover:bg-red-50 transition text-sm font-medium">
                            Logout
                        </button>
                    </form>
                @else
                    {{-- TAMPILAN TAMU --}}
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900 font-medium">Log in</a>
                    <a href="{{ route('register') }}" class="bg-blue-600 text-white px-5 py-2 rounded-md hover:bg-blue-700 transition font-medium shadow-sm">Register</a>
                @endauth
            </div>
        @endif
    </div>

    {{-- 3. SEARCH BAR --}}
    <div class="mb-8 flex justify-center md:justify-start">
        <form action="{{ route('home') }}" method="GET" class="flex gap-2 w-full max-w-lg">
            <input 
                type="text" 
                name="search" 
                value="{{ request('search') }}" 
                placeholder="Cari merk atau model mobil..." 
                class="w-full border border-gray-300 px-4 py-2 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
            >
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md shadow-md hover:bg-blue-700 transition font-semibold">
                Cari
            </button>
            @if(request('search'))
                <a href="{{ route('home') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md shadow-md hover:bg-gray-600 transition flex items-center font-medium">
                    Reset
                </a>
            @endif
        </form>
    </div>

    {{-- 4. GRID DAFTAR MOBIL --}}
    @if($cars->isEmpty())
        <div class="text-center py-16 bg-white rounded-lg shadow-sm border border-dashed border-gray-300">
            <p class="text-gray-500 text-xl font-medium">Mobil yang Anda cari tidak ditemukan.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($cars as $car)
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300 flex flex-col justify-between border border-gray-100 group">
                
                {{-- Gambar Mobil --}}
                <div class="relative h-56 bg-gray-200">
                    <img src="{{ Storage::url($car->image) }}" alt="{{ $car->brand }}" class="w-full h-full object-cover">
                    
                    {{-- Badge Tahun --}}
                    <div class="absolute top-0 right-0 bg-blue-600 text-white text-xs font-bold px-3 py-1 rounded-bl-lg z-10">
                        {{ $car->year ?? 'Baru' }}
                    </div>

                    {{-- TOMBOL LOVE / WISHLIST (BARU) --}}
                    @auth
                        <form action="{{ route('wishlist.toggle', $car->id) }}" method="POST" class="absolute top-2 left-2 z-20">
                            @csrf
                            {{-- Cek apakah mobil ada di wishlist user, ubah warna sesuai status --}}
                            <button type="submit" class="p-2 rounded-full shadow-md transition transform hover:scale-110 {{ Auth::user()->wishlist->contains($car->id) ? 'bg-red-500 text-white' : 'bg-white text-gray-400 hover:text-red-500' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="{{ Auth::user()->wishlist->contains($car->id) ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </button>
                        </form>
                    @endauth
                </div>

                <div class="p-5 flex flex-col flex-grow">
                    <h2 class="text-2xl font-bold text-gray-800 mb-1 uppercase">{{ $car->brand }}</h2>
                    <h3 class="text-lg font-medium text-gray-500 mb-3">{{ $car->model }}</h3>
                    
                    <p class="text-blue-600 font-extrabold text-xl mb-3">
                        Rp {{ number_format($car->price, 0, ',', '.') }}
                    </p>
                    
                    <p class="text-gray-500 text-sm line-clamp-2 mb-4">
                        {{ $car->description }}
                    </p>
                </div>

                {{-- Tombol Aksi --}}
                <div class="bg-gray-50 p-4 border-t border-gray-100 flex flex-col gap-2">
                    <a href="{{ route('car.show', $car->id) }}" class="block w-full text-center bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition font-medium shadow-sm">
                        Lihat Detail
                    </a>

                    @auth
                        @if(Auth::user()->role == 'admin')
                            <div class="flex gap-2 mt-1">
                                <a href="{{ route('car.edit', $car->id) }}" class="w-1/2 text-center bg-yellow-400 text-white py-2 rounded-md hover:bg-yellow-500 transition font-medium shadow-sm">
                                    Edit
                                </a>
                                
                                <form action="{{ route('car.destroy', $car->id) }}" method="POST" class="w-1/2" onsubmit="return confirm('Yakin ingin menghapus mobil ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full bg-red-500 text-white py-2 rounded-md hover:bg-red-600 transition font-medium shadow-sm">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        @endif
                    @endauth
                </div>
            </div>
            @endforeach
        </div>

        {{-- 5. PAGINATION --}}
        <div class="mt-10 p-4 flex justify-center">
            {{ $cars->links() }} 
        </div>
    @endif

</body>
</html>