<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Admin / Kontraktor Utama
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'], // Pengecekan berdasarkan email
            [
                'name' => 'Admin Proyek',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ]
        );

        // 2. Akun Klien
        User::updateOrCreate(
            ['email' => 'klien@gmail.com'],
            [
                'name' => 'Pak Gilang (Klien)',
                'password' => Hash::make('password123'),
                'role' => 'klien',
            ]
        );

        // 3. Akun Mitra Kontraktor / Subkon
        User::updateOrCreate(
            ['email' => 'kontraktor@gmail.com'],
            [
                'name' => 'CV. Atap Nusantara',
                'password' => Hash::make('password123'),
                'role' => 'kontraktor',
            ]
        );
    }
}