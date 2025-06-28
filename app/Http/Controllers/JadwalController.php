<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\MataKuliah;
use App\Models\Dosen;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Jadwal::with(['mataKuliah', 'dosen']);
        
        // Filter berdasarkan hari
        if ($request->filled('hari')) {
            $query->where('hari', 'like', '%' . $request->hari . '%');
        }
        
        // Filter berdasarkan mata kuliah
        if ($request->filled('mata_kuliah')) {
            $query->whereHas('mataKuliah', function($q) use ($request) {
                $q->where('nama_mk', 'like', '%' . $request->mata_kuliah . '%');
            });
        }
        
        // Filter berdasarkan dosen
        if ($request->filled('dosen')) {
            $query->whereHas('dosen', function($q) use ($request) {
                $q->where('nama_lengkap', 'like', '%' . $request->dosen . '%');
            });
        }
        
        // Filter berdasarkan semester
        if ($request->filled('semester')) {
            $query->where('semester', 'like', '%' . $request->semester . '%');
        }
        
        $jadwals = $query->paginate(10);
        $mataKuliahs = MataKuliah::all();
        $dosens = Dosen::all();
        
        return view('admin.jadwal.index', compact('jadwals', 'mataKuliahs', 'dosens'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mataKuliahs = MataKuliah::all();
        $dosens = Dosen::all();
        return view('admin.jadwal.create', compact('mataKuliahs', 'dosens'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'hari' => 'required|string|max:20',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'mata_kuliah_id' => 'required|exists:mata_kuliahs,id',
            'dosen_id' => 'required|exists:dosens,id',
            'ruang' => 'required|string|max:50',
            'semester' => 'required|string|max:10',
        ]);
        Jadwal::create($validated);
        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Jadwal $jadwal)
    {
        $jadwal->load(['mataKuliah', 'dosen']);
        return view('admin.jadwal.show', compact('jadwal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jadwal $jadwal)
    {
        $mataKuliahs = MataKuliah::all();
        $dosens = Dosen::all();
        return view('admin.jadwal.edit', compact('jadwal', 'mataKuliahs', 'dosens'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jadwal $jadwal)
    {
        $validated = $request->validate([
            'hari' => 'required|string|max:20',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'mata_kuliah_id' => 'required|exists:mata_kuliahs,id',
            'dosen_id' => 'required|exists:dosens,id',
            'ruang' => 'required|string|max:50',
            'semester' => 'required|string|max:10',
        ]);
        $jadwal->update($validated);
        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jadwal $jadwal)
    {
        $jadwal->delete();
        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil dihapus');
    }

    public function jadwalDosen()
    {
        $dosenId = auth()->user()->id;
        $jadwals = Jadwal::with('mataKuliah')
            ->where('dosen_id', $dosenId)
            ->orderBy('hari')
            ->orderBy('jam_mulai')
            ->get();
        return view('dosen.jadwal', compact('jadwals'));
    }

    public function jadwalMahasiswa()
    {
        $mahasiswa = auth()->user();
        $krs = $mahasiswa->krs()->with('jadwal.mataKuliah', 'jadwal.dosen')->get();
        $jadwals = $krs->pluck('jadwal');
        return view('mahasiswa.jadwal', compact('jadwals'));
    }

    public function exportPDF()
    {
        $jadwals = Jadwal::with(['mataKuliah', 'dosen'])->get();
        $pdf = PDF::loadView('admin.jadwal.pdf', compact('jadwals'));
        return $pdf->download('jadwal-kuliah.pdf');
    }
}
