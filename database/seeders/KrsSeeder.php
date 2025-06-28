<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Krs;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\Dosen;

class KrsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mahasiswas = Mahasiswa::all();
        $mataKuliahs = MataKuliah::all();
        $dosens = Dosen::all();

        if ($mahasiswas->isEmpty() || $mataKuliahs->isEmpty() || $dosens->isEmpty()) {
            $this->command->warn('Mahasiswa, Mata Kuliah, atau Dosen belum ada. Jalankan seeder yang diperlukan terlebih dahulu.');
            return;
        }

        $semesterOptions = ['Ganjil', 'Genap'];
        $tahunAkademikOptions = ['2023/2024', '2024/2025'];

        foreach ($mahasiswas as $mahasiswa) {
            // Setiap mahasiswa mengambil 3-5 mata kuliah
            $jumlahMataKuliah = rand(3, 5);
            $mataKuliahTerpilih = $mataKuliahs->random($jumlahMataKuliah);

            foreach ($mataKuliahTerpilih as $mataKuliah) {
                Krs::create([
                    'mahasiswa_id' => $mahasiswa->id,
                    'mata_kuliah_id' => $mataKuliah->id,
                    'dosen_id' => $dosens->random()->id,
                    'tahun_akademik' => $tahunAkademikOptions[array_rand($tahunAkademikOptions)],
                    'semester' => $semesterOptions[array_rand($semesterOptions)],
                    'status' => 'disetujui',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        $this->command->info('KRS berhasil dibuat untuk ' . $mahasiswas->count() . ' mahasiswa.');
    }
} 