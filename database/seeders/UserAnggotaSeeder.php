<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\RolesEnum;
use App\Models\Anggota;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserAnggotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Akun Administrator
        User::create([
            'username' => "Administrator",
            'password' => Hash::make('password123'),
            'role' => RolesEnum::ADMIN,
        ]);

        // 2. Akun Petugas
        $userSiswa = User::create([
            'username' => "siswa_syahid",
            'password' => Hash::make('password123'),
            'role' => RolesEnum::SISWA,
        ]);

        Anggota::create([
            'user_id'       => $userSiswa->id, // Ambil ID dari user yang baru dibuat
            'nama_anggota'  => 'Umaru Syahid Mas\'udi',
            'nis'           => 12345678,
            'kelas'         => 'XII PPLG 1',
            'no_telp'       => '081234567890',
            'alamat'        => 'Dramaga, Bogor',
        ]);
    }
}
