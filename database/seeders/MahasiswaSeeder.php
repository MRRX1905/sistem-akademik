<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Mahasiswa;
use App\Models\User;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mahasiswas = [
            [
                'nim' => '2021001',
                'nama_lengkap' => 'Ahmad Fauzi',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '2000-03-15',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Sudirman No. 123, Jakarta Pusat',
                'no_hp' => '081234567890',
                'program_studi' => 'Teknik Informatika',
                'angkatan' => 2021,
                'status' => 'aktif',
            ],
            [
                'nim' => '2021002',
                'nama_lengkap' => 'Siti Nurhaliza',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '2001-07-22',
                'jenis_kelamin' => 'P',
                'alamat' => 'Jl. Asia Afrika No. 45, Bandung',
                'no_hp' => '081234567891',
                'program_studi' => 'Sistem Informasi',
                'angkatan' => 2021,
                'status' => 'aktif',
            ],
            [
                'nim' => '2021003',
                'nama_lengkap' => 'Budi Santoso',
                'tempat_lahir' => 'Surabaya',
                'tanggal_lahir' => '2000-11-08',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Pemuda No. 67, Surabaya',
                'no_hp' => '081234567892',
                'program_studi' => 'Teknik Informatika',
                'angkatan' => 2021,
                'status' => 'aktif',
            ],
            [
                'nim' => '2021004',
                'nama_lengkap' => 'Dewi Sartika',
                'tempat_lahir' => 'Semarang',
                'tanggal_lahir' => '2001-04-12',
                'jenis_kelamin' => 'P',
                'alamat' => 'Jl. Pandanaran No. 89, Semarang',
                'no_hp' => '081234567893',
                'program_studi' => 'Sistem Informasi',
                'angkatan' => 2021,
                'status' => 'aktif',
            ],
            [
                'nim' => '2021005',
                'nama_lengkap' => 'Rizki Pratama',
                'tempat_lahir' => 'Yogyakarta',
                'tanggal_lahir' => '2000-09-30',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Malioboro No. 12, Yogyakarta',
                'no_hp' => '081234567894',
                'program_studi' => 'Teknik Informatika',
                'angkatan' => 2021,
                'status' => 'aktif',
            ],
            [
                'nim' => '2022001',
                'nama_lengkap' => 'Nina Safitri',
                'tempat_lahir' => 'Malang',
                'tanggal_lahir' => '2002-01-18',
                'jenis_kelamin' => 'P',
                'alamat' => 'Jl. Merdeka No. 34, Malang',
                'no_hp' => '081234567895',
                'program_studi' => 'Sistem Informasi',
                'angkatan' => 2022,
                'status' => 'aktif',
            ],
            [
                'nim' => '2022002',
                'nama_lengkap' => 'Doni Kusuma',
                'tempat_lahir' => 'Medan',
                'tanggal_lahir' => '2001-12-05',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Gatot Subroto No. 56, Medan',
                'no_hp' => '081234567896',
                'program_studi' => 'Teknik Informatika',
                'angkatan' => 2022,
                'status' => 'aktif',
            ],
            [
                'nim' => '2022003',
                'nama_lengkap' => 'Maya Indah',
                'tempat_lahir' => 'Palembang',
                'tanggal_lahir' => '2002-06-25',
                'jenis_kelamin' => 'P',
                'alamat' => 'Jl. Jendral Sudirman No. 78, Palembang',
                'no_hp' => '081234567897',
                'program_studi' => 'Sistem Informasi',
                'angkatan' => 2022,
                'status' => 'aktif',
            ],
            [
                'nim' => '2022004',
                'nama_lengkap' => 'Eko Prasetyo',
                'tempat_lahir' => 'Solo',
                'tanggal_lahir' => '2001-08-14',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Slamet Riyadi No. 90, Solo',
                'no_hp' => '081234567898',
                'program_studi' => 'Teknik Informatika',
                'angkatan' => 2022,
                'status' => 'aktif',
            ],
            [
                'nim' => '2022005',
                'nama_lengkap' => 'Rina Marlina',
                'tempat_lahir' => 'Makassar',
                'tanggal_lahir' => '2002-02-28',
                'jenis_kelamin' => 'P',
                'alamat' => 'Jl. Pengayoman No. 23, Makassar',
                'no_hp' => '081234567899',
                'program_studi' => 'Sistem Informasi',
                'angkatan' => 2022,
                'status' => 'aktif',
            ],
        ];

        foreach ($mahasiswas as $index => $mahasiswaData) {
            // Buat user untuk mahasiswa
            $user = User::create([
                'name' => $mahasiswaData['nama_lengkap'],
                'email' => strtolower(str_replace(' ', '.', $mahasiswaData['nama_lengkap'])) . '@student.ac.id',
                'username' => strtolower(str_replace(' ', '', $mahasiswaData['nama_lengkap'])),
                'password' => bcrypt('password'),
                'role' => 'mahasiswa',
            ]);

            // Buat mahasiswa dengan user_id
            $mahasiswaData['user_id'] = $user->id;
            Mahasiswa::create($mahasiswaData);
        }

        $this->command->info('Mahasiswa berhasil dibuat: ' . count($mahasiswas) . ' mahasiswa.');
    }
} 