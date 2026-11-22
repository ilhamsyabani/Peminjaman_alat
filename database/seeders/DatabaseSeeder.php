<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Urutan mengikuti dependensi: users -> lokasi -> produk -> member -> transaksi -> post.
     * Semua seeder idempotent (updateOrCreate / firstOrCreate), aman dijalankan ulang.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            LokasiSeeder::class,
            ProductSeeder::class,
            MemberSeeder::class,
            TransaksiSeeder::class,
            PostSeeder::class,
        ]);
    }
}
