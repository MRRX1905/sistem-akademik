<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Nilai;
use App\Models\Krs;
use App\Models\Dosen;

class NilaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $krss = Krs::with(['mahasiswa', 'mataKuliah'])->get();
        $dosens = Dosen::all();

        if ($krss->isEmpty() || $dosens->isEmpty()) {
            $this->command->warn('KRS atau Dosen belum ada. Jalankan KrsSeeder dan DosenSeeder terlebih dahulu.');
            return;
        }

        foreach ($krss as $krs) {
            // Ambil dosen secara random
            $dosen = $dosens->random();
            
            // Generate nilai random yang realistis
            $nilaiTugas = rand(70, 95);
            $nilaiUts = rand(65, 90);
            $nilaiUas = rand(60, 95);
            
            // Hitung nilai akhir (30% tugas + 30% UTS + 40% UAS)
            $nilaiAkhir = round(($nilaiTugas * 0.3) + ($nilaiUts * 0.3) + ($nilaiUas * 0.4), 2);
            
            // Tentukan grade berdasarkan nilai akhir
            $grade = $this->tentukanGrade($nilaiAkhir);
            
            // Catatan random
            $catatanOptions = [
                'Sangat baik dalam mengikuti perkuliahan',
                'Aktif dalam diskusi kelas',
                'Tugas dikumpulkan tepat waktu',
                'Perlu peningkatan dalam pemahaman materi',
                'Sangat rajin dan disiplin',
                'Memiliki potensi yang baik',
                'Perlu lebih aktif dalam praktikum',
                'Hasil kerja yang memuaskan',
                null
            ];
            
            Nilai::create([
                'krs_id' => $krs->id,
                'mahasiswa_id' => $krs->mahasiswa_id,
                'mata_kuliah_id' => $krs->mata_kuliah_id,
                'dosen_id' => $dosen->id,
                'nilai_tugas' => $nilaiTugas,
                'nilai_uts' => $nilaiUts,
                'nilai_uas' => $nilaiUas,
                'nilai_akhir' => $nilaiAkhir,
                'grade' => $grade,
                'catatan' => $catatanOptions[array_rand($catatanOptions)],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('Nilai berhasil dibuat untuk ' . $krss->count() . ' KRS.');
    }

    /**
     * Tentukan grade berdasarkan nilai akhir
     */
    private function tentukanGrade($nilaiAkhir)
    {
        if ($nilaiAkhir >= 85) {
            return 'A';
        } elseif ($nilaiAkhir >= 75) {
            return 'B';
        } elseif ($nilaiAkhir >= 65) {
            return 'C';
        } elseif ($nilaiAkhir >= 50) {
            return 'D';
        } else {
            return 'E';
        }
    }
} 