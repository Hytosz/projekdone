<!DOCTYPE html>
<html>
<head>
    <title>Checkout Mobil</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10 flex justify-center">
    <div class="bg-white p-8 rounded shadow max-w-md w-full">
        <h1 class="text-2xl font-bold mb-4">Checkout</h1>
        <div class="mb-4 border-b pb-4">
            <h2 class="text-xl">{{ $car->brand }} {{ $car->model }}</h2>
            <p class="text-blue-600 font-bold">Rp {{ number_format($car->price) }}</p>
        </div>

        <form action="{{ route('transaction.store', $car->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block mb-2">Upload Bukti Transfer:</label>
                <input type="file" name="payment_proof" class="w-full border p-2 rounded" required>
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded">Kirim Bukti Pembayaran</button>
        </form>
    </div>
</body>
</html>