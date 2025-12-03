<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany; // [Wajib] Import untuk relasi wishlist

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // [Penting] Tambahkan ini agar kolom role bisa diisi
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi Wishlist (User menyukai banyak Mobil)
     * Definisikan relasi Many-to-Many ke model Car
     */
    public function wishlist(): BelongsToMany
    {
        // Parameter: (Model Tujuan, Nama Tabel Pivot, Foreign Key User, Foreign Key Car)
        return $this->belongsToMany(Car::class, 'wishlists', 'user_id', 'car_id')->withTimestamps();
    }
}