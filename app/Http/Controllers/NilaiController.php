<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use App\Models\Krs;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NilaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $nilais = Nilai::with(['mahasiswa', 'mataKuliah', 'dosen'])->paginate(10);
        return view('admin.nilai.index', compact('nilais'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $krss = Krs::where('status', 'disetujui')->with(['mahasiswa', 'mataKuliah', 'dosen'])->get();
        $mahasiswas = Mahasiswa::all();
        $mataKuliahs = MataKuliah::all();
        $dosens = Dosen::all();
        return view('admin.nilai.create', compact('krss', 'mahasiswas', 'mataKuliahs', 'dosens'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'krs_id' => 'required|exists:krs,id',
            'mahasiswa_id' => 'required|exists:mahasiswas,id',
            'mata_kuliah_id' => 'required|exists:mata_kuliahs,id',
            'dosen_id' => 'required|exists:dosens,id',
            'nilai_tugas' => 'required|numeric|min:0|max:100',
            'nilai_uts' => 'required|numeric|min:0|max:100',
            'nilai_uas' => 'required|numeric|min:0|max:100',
            'catatan' => 'nullable|string',
        ]);

        // Calculate final grade
        $nilai_akhir = ($validated['nilai_tugas'] * 0.3) + ($validated['nilai_uts'] * 0.3) + ($validated['nilai_uas'] * 0.4);
        
        // Determine grade
        $grade = $this->calculateGrade($nilai_akhir);

        $validated['nilai_akhir'] = round($nilai_akhir, 2);
        $validated['grade'] = $grade;

        Nilai::create($validated);

        return redirect()->route('nilai.index')->with('success', 'Nilai berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Nilai $nilai)
    {
        return view('admin.nilai.show', compact('nilai'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Nilai $nilai)
    {
        $krss = Krs::where('status', 'disetujui')->with(['mahasiswa', 'mataKuliah', 'dosen'])->get();
        $mahasiswas = Mahasiswa::all();
        $mataKuliahs = MataKuliah::all();
        $dosens = Dosen::all();
        return view('admin.nilai.edit', compact('nilai', 'krss', 'mahasiswas', 'mataKuliahs', 'dosens'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Nilai $nilai)
    {
        $validated = $request->validate([
            'nilai_tugas' => 'required|numeric|min:0|max:100',
            'nilai_uts' => 'required|numeric|min:0|max:100',
            'nilai_uas' => 'required|numeric|min:0|max:100',
            'catatan' => 'nullable|string',
        ]);

        // Calculate final grade
        $nilai_akhir = ($validated['nilai_tugas'] * 0.3) + ($validated['nilai_uts'] * 0.3) + ($validated['nilai_uas'] * 0.4);
        
        // Determine grade
        $grade = $this->calculateGrade($nilai_akhir);

        $validated['nilai_akhir'] = round($nilai_akhir, 2);
        $validated['grade'] = $grade;

        $nilai->update($validated);

        return redirect()->route('nilai.index')->with('success', 'Nilai berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Nilai $nilai)
    {
        $nilai->delete();

        return redirect()->route('nilai.index')->with('success', 'Nilai berhasil dihapus');
    }

    // Dosen methods
    public function dosenIndex()
    {
        $user = Auth::user();
        $dosen = $user->dosen;
        $nilais = Nilai::where('dosen_id', $dosen->id)
                       ->with(['mahasiswa', 'mataKuliah'])
                       ->paginate(10);
        return view('dosen.nilai.index', compact('nilais'));
    }

    public function dosenEdit(Nilai $nilai)
    {
        // Check if dosen owns this nilai
        $user = Auth::user();
        if ($nilai->dosen_id !== $user->dosen->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('dosen.nilai.edit', compact('nilai'));
    }

    public function dosenUpdate(Request $request, Nilai $nilai)
    {
        // Check if dosen owns this nilai
        $user = Auth::user();
        if ($nilai->dosen_id !== $user->dosen->id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'nilai_tugas' => 'required|numeric|min:0|max:100',
            'nilai_uts' => 'required|numeric|min:0|max:100',
            'nilai_uas' => 'required|numeric|min:0|max:100',
            'catatan' => 'nullable|string',
        ]);

        // Calculate final grade
        $nilai_akhir = ($validated['nilai_tugas'] * 0.3) + ($validated['nilai_uts'] * 0.3) + ($validated['nilai_uas'] * 0.4);
        
        // Determine grade
        $grade = $this->calculateGrade($nilai_akhir);

        $validated['nilai_akhir'] = round($nilai_akhir, 2);
        $validated['grade'] = $grade;

        $nilai->update($validated);

        return redirect()->route('dosen.nilai.index')->with('success', 'Nilai berhasil diperbarui');
    }

    // Mahasiswa methods
    public function mahasiswaIndex()
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;
        $nilais = Nilai::where('mahasiswa_id', $mahasiswa->id)
                       ->with(['mataKuliah', 'dosen'])
                       ->paginate(10);
        return view('mahasiswa.nilai.index', compact('nilais'));
    }

    private function calculateGrade($nilai_akhir)
    {
        if ($nilai_akhir >= 85) return 'A';
        if ($nilai_akhir >= 75) return 'B';
        if ($nilai_akhir >= 65) return 'C';
        if ($nilai_akhir >= 50) return 'D';
        return 'E';
    }
}
