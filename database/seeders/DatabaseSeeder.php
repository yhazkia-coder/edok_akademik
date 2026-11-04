<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\JenisLayanan;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Buat Akun Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);

        // Buat Akun Siswa
        User::create([
            'name' => 'Siswa Test',
            'email' => 'siswa@gmail.com',
            'password' => bcrypt('password123'),
            'role' => 'siswa',
        ]);

        // Buat Contoh Jenis Layanan Akademik
        JenisLayanan::create([
            'nama_layanan' => 'Legalisir Ijazah / SKHUN',
            'deskripsi' => 'Layanan legalisir dokumen kelulusan sekolah.'
        ]);

        JenisLayanan::create([
            'nama_layanan' => 'Surat Keterangan Aktif Siswa',
            'deskripsi' => 'Surat keterangan bahwa siswa masih aktif belajar.'
        ]);
    }
}