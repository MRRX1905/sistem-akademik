<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MataKuliah;

class MataKuliahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mataKuliah = [
            [
                'kode_mk' => 'IF101',
                'nama_mk' => 'Pemrograman Dasar',
                'sks' => 3,
                'semester' => '1',
                'program_studi' => 'Teknik Informatika',
                'deskripsi' => 'Mata kuliah dasar pemrograman menggunakan bahasa C',
                'status' => 'aktif',
            ],
            [
                'kode_mk' => 'IF102',
                'nama_mk' => 'Algoritma dan Struktur Data',
                'sks' => 3,
                'semester' => '2',
                'program_studi' => 'Teknik Informatika',
                'deskripsi' => 'Mata kuliah algoritma dan struktur data dasar',
                'status' => 'aktif',
            ],
            [
                'kode_mk' => 'IF201',
                'nama_mk' => 'Pemrograman Web',
                'sks' => 3,
                'semester' => '3',
                'program_studi' => 'Teknik Informatika',
                'deskripsi' => 'Mata kuliah pemrograman web menggunakan HTML, CSS, JavaScript',
                'status' => 'aktif',
            ],
            [
                'kode_mk' => 'IF202',
                'nama_mk' => 'Basis Data',
                'sks' => 3,
                'semester' => '3',
                'program_studi' => 'Teknik Informatika',
                'deskripsi' => 'Mata kuliah sistem basis data dan SQL',
                'status' => 'aktif',
            ],
            [
                'kode_mk' => 'SI101',
                'nama_mk' => 'Pengantar Sistem Informasi',
                'sks' => 3,
                'semester' => '1',
                'program_studi' => 'Sistem Informasi',
                'deskripsi' => 'Mata kuliah pengantar sistem informasi',
                'status' => 'aktif',
            ],
            [
                'kode_mk' => 'SI102',
                'nama_mk' => 'Analisis dan Perancangan Sistem',
                'sks' => 3,
                'semester' => '2',
                'program_studi' => 'Sistem Informasi',
                'deskripsi' => 'Mata kuliah analisis dan perancangan sistem informasi',
                'status' => 'aktif',
            ],
            [
                'kode_mk' => 'SI201',
                'nama_mk' => 'Pemrograman Berorientasi Objek',
                'sks' => 3,
                'semester' => '3',
                'program_studi' => 'Sistem Informasi',
                'deskripsi' => 'Mata kuliah pemrograman berorientasi objek menggunakan Java',
                'status' => 'aktif',
            ],
            [
                'kode_mk' => 'SI202',
                'nama_mk' => 'Manajemen Proyek TI',
                'sks' => 3,
                'semester' => '4',
                'program_studi' => 'Sistem Informasi',
                'deskripsi' => 'Mata kuliah manajemen proyek teknologi informasi',
                'status' => 'aktif',
            ],
        ];

        foreach ($mataKuliah as $mk) {
            MataKuliah::create($mk);
        }
    }
}
