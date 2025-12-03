<?php
namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TransactionController extends Controller
{
    // 1. [USER] Tampilkan Form Beli
    public function checkout($id)
    {
        $car = Car::findOrFail($id);
        return view('checkout', compact('car'));
    }

    // 2. [USER] Proses Upload Bukti Bayar
    public function store(Request $request, $id)
    {
        $request->validate([
            'payment_proof' => 'required|image|max:2048',
        ]);

        $path = $request->file('payment_proof')->store('payments', 'public');

        Transaction::create([
            'user_id' => Auth::id(),
            'car_id' => $id,
            'payment_proof' => $path,
            'status' => 'pending', // Status awal
        ]);

        return redirect()->route('history')->with('success', 'Pembelian berhasil! Menunggu konfirmasi admin.');
    }

    // 3. [USER] Halaman Riwayat & Review
    public function history()
    {
        // Ambil transaksi milik user yang sedang login
        $transactions = Transaction::where('user_id', Auth::id())->with('car')->latest()->get();
        return view('history', compact('transactions'));
    }

    // 4. [ADMIN] Halaman Daftar Pesanan Masuk
    public function indexAdmin()
    {
        $transactions = Transaction::with(['user', 'car'])->latest()->get();
        return view('admin.transactions.index', compact('transactions'));
    }

    // 5. [ADMIN] Update Status (Pending -> Processing -> Shipped)
    public function updateStatus(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->update(['status' => $request->status]);

        return back()->with('success', 'Status transaksi diperbarui!');
    }

    // 6. [USER] Kirim Review (Status Shipped -> Completed)
    public function submitReview(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string',
        ]);

        $transaction = Transaction::findOrFail($id);

        // Pastikan status sebelumnya adalah 'shipped' sebelum bisa review
        if($transaction->status == 'shipped') {
            $transaction->update([
                'rating' => $request->rating,
                'review' => $request->review,
                'status' => 'completed' // Otomatis jadi Selesai
            ]);
        }

        return back()->with('success', 'Terima kasih atas ulasan Anda!');
    }
}