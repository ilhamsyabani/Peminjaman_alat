<?php

namespace Database\Seeders;

use App\Models\Member;
use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
{
    public function run(): void
    {
        $members = [
            // NIK, nama, email, hp, alamat, info, status
            ['3273012001990001', 'Andi Pratama', 'andi.pratama@mail.test', '081234567801', 'Jl. Dago No. 12, Bandung', 'Mahasiswa Teknik Informatika', 'tidak_ada'],
            ['3273014502000002', 'Dewi Lestari', 'dewi.lestari@mail.test', '081234567802', 'Jl. Setiabudi No. 45, Bandung', null, 'meminjam'],
            ['3578011203980003', 'Rizky Hidayat', 'rizky.hidayat@mail.test', '081234567803', 'Jl. Darmo No. 7, Surabaya', 'Staf Tata Usaha', 'tidak_ada'],
            ['3174016607010004', 'Putri Ayu Wulandari', 'putri.ayu@mail.test', '081234567804', 'Jl. Kemang Raya No. 3, Jakarta Selatan', null, 'process'],
            ['3471010909970005', 'Fajar Nugroho', 'fajar.nugroho@mail.test', '081234567805', 'Jl. Malioboro No. 88, Yogyakarta', 'Dosen Fakultas Teknik', 'tidak_ada'],
            ['3201010101010006', 'Member Tanpa Info', 'tanpa.info@mail.test', '0800000000', '-', null, 'tidak_ada'], // edge: data minimal
        ];

        foreach ($members as [$nik, $name, $email, $hp, $address, $info, $status]) {
            Member::updateOrCreate(['identity_number' => $nik], [
                'photo' => 'uploads/member-' . substr($nik, -4) . '.png',
                'name' => $name,
                'email' => $email,
                'hp' => $hp,
                'address' => $address,
                'info' => $info,
                'status' => $status,
            ]);
        }
    }
}
