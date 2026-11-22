<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $author = User::where('email', 'admin@peminjaman.test')->firstOrFail();

        $posts = [
            ['Tata Cara Peminjaman Barang Inventaris', 'panduan', 'Peminjam wajib membawa kartu identitas sebagai jaminan. Barang dikembalikan paling lambat 7 hari setelah dipinjam dalam kondisi baik.'],
            ['Jadwal Libur Layanan Akhir Tahun', 'pengumuman', 'Layanan peminjaman ditutup sementara pada tanggal 24 Desember hingga 1 Januari. Pengembalian tetap dapat dilakukan di pos satpam.'],
            ['Penambahan Kamera Baru di Laboratorium Multimedia', 'berita', 'Laboratorium Multimedia menerima dua unit kamera mirrorless baru yang dapat dipinjam oleh mahasiswa untuk keperluan tugas akhir.'],
        ];

        foreach ($posts as [$title, $category, $content]) {
            Post::updateOrCreate(['slug' => Str::slug($title)], [
                'title' => $title,
                'category' => $category,
                'content' => $content,
                'excerpt' => Str::limit($content, 120, '...'),
                'user_id' => $author->id,
            ]);
        }
    }
}
