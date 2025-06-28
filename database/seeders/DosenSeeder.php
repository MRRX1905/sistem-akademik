<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Dosen;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DosenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dosens = [
            [
                'nip' => '19800101198001001',
                'nama_lengkap' => 'Dr. Ahmad Hidayat, M.Kom',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '1980-01-01',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Sudirman No. 123, Jakarta',
                'no_hp' => '081234567890',
                'bidang_keahlian' => 'Pemrograman Web',
                'pendidikan_terakhir' => 'S3',
                'status' => 'aktif',
                'email' => 'ahmad.hidayat@example.com',
                'username' => 'ahmad.hidayat',
                'password' => 'password123',
            ],
            [
                'nip' => '19850202198502002',
                'nama_lengkap' => 'Siti Nurhaliza, M.T',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '1985-02-02',
                'jenis_kelamin' => 'P',
                'alamat' => 'Jl. Asia Afrika No. 456, Bandung',
                'no_hp' => '081234567891',
                'bidang_keahlian' => 'Basis Data',
                'pendidikan_terakhir' => 'S2',
                'status' => 'aktif',
                'email' => 'siti.nurhaliza@example.com',
                'username' => 'siti.nurhaliza',
                'password' => 'password123',
            ],
            [
                'nip' => '19900303199003003',
                'nama_lengkap' => 'Budi Santoso, S.Kom',
                'tempat_lahir' => 'Surabaya',
                'tanggal_lahir' => '1990-03-03',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Pemuda No. 789, Surabaya',
                'no_hp' => '081234567892',
                'bidang_keahlian' => 'Jaringan Komputer',
                'pendidikan_terakhir' => 'S1',
                'status' => 'aktif',
                'email' => 'budi.santoso@example.com',
                'username' => 'budi.santoso',
                'password' => 'password123',
            ],
            [
                'nip' => '19920404199204004',
                'nama_lengkap' => 'Dewi Sartika, M.Kom',
                'tempat_lahir' => 'Semarang',
                'tanggal_lahir' => '1992-04-04',
                'jenis_kelamin' => 'P',
                'alamat' => 'Jl. Pandanaran No. 321, Semarang',
                'no_hp' => '081234567893',
                'bidang_keahlian' => 'Kecerdasan Buatan',
                'pendidikan_terakhir' => 'S2',
                'status' => 'aktif',
                'email' => 'dewi.sartika@example.com',
                'username' => 'dewi.sartika',
                'password' => 'password123',
            ],
            [
                'nip' => '19880705198807005',
                'nama_lengkap' => 'Rudi Hermawan, S.T',
                'tempat_lahir' => 'Yogyakarta',
                'tanggal_lahir' => '1988-07-05',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Malioboro No. 654, Yogyakarta',
                'no_hp' => '081234567894',
                'bidang_keahlian' => 'Sistem Informasi',
                'pendidikan_terakhir' => 'S1',
                'status' => 'aktif',
                'email' => 'rudi.hermawan@example.com',
                'username' => 'rudi.hermawan',
                'password' => 'password123',
            ],
        ];

        foreach ($dosens as $dosenData) {
            $user = User::create([
                'name' => $dosenData['nama_lengkap'],
                'email' => $dosenData['email'],
                'username' => $dosenData['username'],
                'password' => Hash::make($dosenData['password']),
                'role' => 'dosen',
            ]);

            Dosen::create([
                'user_id' => $user->id,
                'nip' => $dosenData['nip'],
                'nama_lengkap' => $dosenData['nama_lengkap'],
                'tempat_lahir' => $dosenData['tempat_lahir'],
                'tanggal_lahir' => $dosenData['tanggal_lahir'],
                'jenis_kelamin' => $dosenData['jenis_kelamin'],
                'alamat' => $dosenData['alamat'],
                'no_hp' => $dosenData['no_hp'],
                'bidang_keahlian' => $dosenData['bidang_keahlian'],
                'pendidikan_terakhir' => $dosenData['pendidikan_terakhir'],
                'status' => $dosenData['status'],
            ]);
        }
    }
} 