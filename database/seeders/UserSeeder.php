<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Aplikasi tidak memiliki sistem role; hanya "user terautentikasi" vs "tamu".
 * Seeder membuat beberapa user untuk variasi (terverifikasi / belum).
 * Password semua akun: "password".
 */
class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['email' => 'admin@peminjaman.test', 'name' => 'Administrator Peminjaman', 'verified' => true],
            ['email' => 'petugas@peminjaman.test', 'name' => 'Siti Rahmawati', 'verified' => true],
            ['email' => 'baru@peminjaman.test', 'name' => 'Budi Santoso', 'verified' => false], // edge: belum verifikasi
        ];

        foreach ($users as $u) {
            $user = User::updateOrCreate(
                ['email' => $u['email']],
                ['name' => $u['name'], 'password' => Hash::make('password')]
            );
            $user->forceFill(['email_verified_at' => $u['verified'] ? now() : null])->save();
        }
    }
}
