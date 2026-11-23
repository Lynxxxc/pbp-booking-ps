<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Akun demo untuk pengujian lokal, mengikuti database rental_ps
     * (email sama dengan data awal dari bagian database: Abiyyu).
     * Password berupa teks biasa di sini aman karena model User
     * meng-hash otomatis lewat cast 'hashed'.
     * GANTI password akun-akun ini sebelum dipakai di luar lingkungan demo.
     */
    public function run(): void
    {
        $akun = [
            ['name' => 'Admin', 'email' => 'admin@gmail.com', 'password' => 'admin123', 'role' => 'admin'],
            ['name' => 'Pegawai Rental', 'email' => 'pegawai@gmail.com', 'password' => 'pegawai123', 'role' => 'pegawai'],
            ['name' => 'Pengguna Demo', 'email' => 'user@gmail.com', 'password' => 'user12345', 'role' => 'pengguna'],
        ];

        foreach ($akun as $a) {
            User::updateOrCreate(
                ['email' => $a['email']],
                [
                    'name' => $a['name'],
                    'password' => $a['password'],
                    'role' => $a['role'],
                    'poin' => 0,
                ]
            );
        }
    }
}
