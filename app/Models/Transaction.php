<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id', 'car_id', 'payment_proof', 'status', 'rating', 'review'
    ];

    // Relasi ke User (Pembeli)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Mobil
    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}