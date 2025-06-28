<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Dosen;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@kampus.com',
            'username' => 'admin',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create Dosen User
        $dosenUser = User::create([
            'name' => 'Dr. Ahmad Supriyadi',
            'email' => 'ahmad@kampus.com',
            'username' => 'dosen1',
            'password' => Hash::make('password'),
            'role' => 'dosen',
        ]);

        $dosen = Dosen::create([
            'user_id' => $dosenUser->id,
            'nip' => '198501012010011001',
            'nama_lengkap' => 'Dr. Ahmad Supriyadi, M.Kom',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '1985-01-01',
            'jenis_kelamin' => 'L',
            'alamat' => 'Jl. Sudirman No. 123, Jakarta',
            'no_hp' => '081234567890',
            'bidang_keahlian' => 'Teknik Informatika',
            'pendidikan_terakhir' => 'S3',
            'status' => 'aktif',
        ]);

        // Create additional dosen
        $dosen2User = User::create([
            'name' => 'Dr. Siti Nurhaliza',
            'email' => 'siti@kampus.com',
            'username' => 'dosen2',
            'password' => Hash::make('password'),
            'role' => 'dosen',
        ]);

        Dosen::create([
            'user_id' => $dosen2User->id,
            'nip' => '198602022010012002',
            'nama_lengkap' => 'Dr. Siti Nurhaliza, M.Si',
            'tempat_lahir' => 'Surabaya',
            'tanggal_lahir' => '1986-02-02',
            'jenis_kelamin' => 'P',
            'alamat' => 'Jl. Pemuda No. 789, Surabaya',
            'no_hp' => '081234567892',
            'bidang_keahlian' => 'Sistem Informasi',
            'pendidikan_terakhir' => 'S3',
            'status' => 'aktif',
        ]);
    }
}
