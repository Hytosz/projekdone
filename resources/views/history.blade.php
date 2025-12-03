<!DOCTYPE html>
<html>
<head>
    <title>Riwayat Pembelian</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Riwayat Pembelian</h1>
            <a href="/" class="text-blue-500">Kembali ke Home</a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded mb-4">{{ session('success') }}</div>
        @endif

        <div class="space-y-4">
            @foreach($transactions as $trx)
            <div class="bg-white p-6 rounded shadow flex flex-col md:flex-row gap-6">
                <img src="{{ Storage::url($trx->car->image) }}" class="w-32 h-24 object-cover rounded">
                
                <div class="flex-1">
                    <h2 class="text-xl font-bold">{{ $trx->car->brand }} {{ $trx->car->model }}</h2>
                    <p class="text-gray-600">Total: Rp {{ number_format($trx->car->price) }}</p>
                    
                    <div class="mt-2">
                        Status: 
                        <span class="px-2 py-1 rounded text-sm font-bold 
                            {{ $trx->status == 'pending' ? 'bg-yellow-200 text-yellow-800' : '' }}
                            {{ $trx->status == 'processing' ? 'bg-blue-200 text-blue-800' : '' }}
                            {{ $trx->status == 'shipped' ? 'bg-purple-200 text-purple-800' : '' }}
                            {{ $trx->status == 'completed' ? 'bg-green-200 text-green-800' : '' }}">
                            {{ strtoupper($trx->status) }}
                        </span>
                    </div>

                    {{-- FORM REVIEW: Muncul HANYA jika status 'shipped' --}}
                    @if($trx->status == 'shipped')
                        <div class="mt-4 bg-gray-50 p-4 rounded border">
                            <h3 class="font-bold mb-2">Barang sudah diterima? Beri Ulasan:</h3>
                            <form action="{{ route('transaction.review', $trx->id) }}" method="POST">
                                @csrf
                                <select name="rating" class="border p-2 rounded mb-2 w-full">
                                    <option value="5">⭐⭐⭐⭐⭐ (Sangat Puas)</option>
                                    <option value="4">⭐⭐⭐⭐ (Puas)</option>
                                    <option value="3">⭐⭐⭐ (Cukup)</option>
                                    <option value="2">⭐⭐ (Kurang)</option>
                                    <option value="1">⭐ (Buruk)</option>
                                </select>
                                <textarea name="review" placeholder="Tulis ulasan..." class="w-full border p-2 rounded mb-2" required></textarea>
                                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded text-sm">Konfirmasi Terima & Kirim Review</button>
                            </form>
                        </div>
                    @endif

                    {{-- TAMPILKAN REVIEW: Jika sudah completed --}}
                    @if($trx->status == 'completed')
                        <div class="mt-4 text-sm text-gray-600">
                            <p><strong>Rating Anda:</strong> {{ $trx->rating }} Bintang</p>
                            <p><strong>Ulasan:</strong> "{{ $trx->review }}"</p>
                        </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</body>
</html>