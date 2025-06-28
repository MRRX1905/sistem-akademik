<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\MataKuliah;
use App\Models\Krs;
use App\Models\Nilai;
use App\Models\Jadwal;

class DashboardController extends Controller
{
    public function adminDashboard()
    {
        $totalMahasiswa = Mahasiswa::count();
        $totalDosen = Dosen::count();
        $totalMataKuliah = MataKuliah::count();
        $totalKrs = Krs::count();
        $totalJadwal = Jadwal::count();
        $rataRataNilai = \App\Models\Nilai::avg('nilai_akhir');
        $distribusiGrade = \App\Models\Nilai::selectRaw('grade, COUNT(*) as jumlah')->groupBy('grade')->pluck('jumlah', 'grade');
        
        return view('admin.dashboard', compact('totalMahasiswa', 'totalDosen', 'totalMataKuliah', 'totalKrs', 'totalJadwal', 'rataRataNilai', 'distribusiGrade'));
    }

    public function dosenDashboard()
    {
        $user = Auth::user();
        $dosen = $user->dosen;
        
        $totalKrs = Krs::where('dosen_id', $dosen->id)->count();
        $totalNilai = Nilai::where('dosen_id', $dosen->id)->count();
        
        return view('dosen.dashboard', compact('dosen', 'totalKrs', 'totalNilai'));
    }

    public function mahasiswaDashboard()
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;
        
        $totalKrs = Krs::where('mahasiswa_id', $mahasiswa->id)->count();
        $totalNilai = Nilai::where('mahasiswa_id', $mahasiswa->id)->count();
        
        return view('mahasiswa.dashboard', compact('mahasiswa', 'totalKrs', 'totalNilai'));
    }
}
