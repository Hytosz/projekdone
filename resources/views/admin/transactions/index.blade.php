<!DOCTYPE html>
<html>
<head>
    <title>Admin - Daftar Transaksi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">
    <div class="max-w-6xl mx-auto bg-white p-6 rounded shadow">
        <div class="flex justify-between mb-6">
            <h1 class="text-2xl font-bold">Daftar Transaksi Masuk</h1>
            <a href="{{ route('home') }}" class="text-blue-500">Kembali ke Dashboard</a>
        </div>

        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b">
                    <th class="p-3">Pembeli</th>
                    <th class="p-3">Mobil</th>
                    <th class="p-3">Bukti Bayar</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Aksi (Update Status)</th>
                    <th class="p-3">Review User</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $trx)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-3">{{ $trx->user->name }}</td>
                    <td class="p-3">{{ $trx->car->brand }} {{ $trx->car->model }}</td>
                    <td class="p-3">
                        <a href="{{ Storage::url($trx->payment_proof) }}" target="_blank" class="text-blue-500 underline text-sm">Lihat Bukti</a>
                    </td>
                    <td class="p-3">
                        <span class="font-bold uppercase text-sm">{{ $trx->status }}</span>
                    </td>
                    <td class="p-3">
                        {{-- Form Update Status --}}
                        <form action="{{ route('admin.transaction.update', $trx->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <select name="status" onchange="this.form.submit()" class="border p-1 rounded text-sm bg-gray-50">
                                <option value="pending" {{ $trx->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ $trx->status == 'processing' ? 'selected' : '' }}>Proses</option>
                                <option value="shipped" {{ $trx->status == 'shipped' ? 'selected' : '' }}>Dikirim</option>
                                <option value="completed" {{ $trx->status == 'completed' ? 'selected' : '' }} disabled>Selesai</option>
                            </select>
                        </form>
                    </td>
                    <td class="p-3 text-sm">
                        @if($trx->status == 'completed')
                            ⭐{{ $trx->rating }} - "{{ $trx->review }}"
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>