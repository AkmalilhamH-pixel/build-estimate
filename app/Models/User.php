<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
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
        'role', // Menambahkan atribut role ke mass assignable
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

    // ─── HELPER FUNCTIONS PENGECEKAN HAK AKSES (ROLE) ───

    /**
     * Memeriksa apakah pengguna memiliki peran Admin / Kontraktor Utama
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Memeriksa apakah pengguna memiliki peran Klien / Pemilik
     */
    public function isKlien(): bool
    {
        return $this->role === 'klien';
    }

    /**
     * Memeriksa apakah pengguna memiliki peran Mitra Kontraktor / Subkon
     */
    public function isKontraktor(): bool
    {
        return $this->role === 'kontraktor';
    }
}