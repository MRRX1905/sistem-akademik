<?php

namespace App\Http\Controllers;

use App\Models\Krs;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KrsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $krss = Krs::with(['mahasiswa', 'mataKuliah', 'dosen'])->paginate(10);
        return view('admin.krs.index', compact('krss'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mahasiswas = Mahasiswa::all();
        $mataKuliahs = MataKuliah::where('status', 'aktif')->get();
        $dosens = Dosen::all();
        return view('admin.krs.create', compact('mahasiswas', 'mataKuliahs', 'dosens'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'mahasiswa_id' => 'required|exists:mahasiswas,id',
            'mata_kuliah_id' => 'required|exists:mata_kuliahs,id',
            'dosen_id' => 'required|exists:dosens,id',
            'tahun_akademik' => 'required|string|max:20',
            'semester' => 'required|string|max:20',
            'status' => 'required|in:pending,disetujui,ditolak',
        ]);

        Krs::create($validated);

        return redirect()->route('krs.index')->with('success', 'KRS berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Krs $krs)
    {
        return view('admin.krs.show', compact('krs'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Krs $krs)
    {
        $mahasiswas = Mahasiswa::all();
        $mataKuliahs = MataKuliah::where('status', 'aktif')->get();
        $dosens = Dosen::all();
        return view('admin.krs.edit', compact('krs', 'mahasiswas', 'mataKuliahs', 'dosens'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Krs $krs)
    {
        $validated = $request->validate([
            'mahasiswa_id' => 'required|exists:mahasiswas,id',
            'mata_kuliah_id' => 'required|exists:mata_kuliahs,id',
            'dosen_id' => 'required|exists:dosens,id',
            'tahun_akademik' => 'required|string|max:20',
            'semester' => 'required|string|max:20',
            'status' => 'required|in:pending,disetujui,ditolak',
        ]);

        $krs->update($validated);

        return redirect()->route('krs.index')->with('success', 'KRS berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Krs $krs)
    {
        $krs->delete();

        return redirect()->route('krs.index')->with('success', 'KRS berhasil dihapus');
    }

    // Mahasiswa methods
    public function mahasiswaIndex()
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;
        $krss = Krs::where('mahasiswa_id', $mahasiswa->id)
                   ->with(['mataKuliah', 'dosen'])
                   ->paginate(10);
        return view('mahasiswa.krs.index', compact('krss'));
    }

    public function mahasiswaCreate()
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;
        $mataKuliahs = MataKuliah::where('status', 'aktif')->get();
        $dosens = Dosen::all();
        return view('mahasiswa.krs.create', compact('mahasiswa', 'mataKuliahs', 'dosens'));
    }

    public function mahasiswaStore(Request $request)
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

        $validated = $request->validate([
            'mata_kuliah_id' => 'required|exists:mata_kuliahs,id',
            'dosen_id' => 'required|exists:dosens,id',
            'tahun_akademik' => 'required|string|max:20',
            'semester' => 'required|string|max:20',
        ]);

        // Check if already registered for this course
        $existingKrs = Krs::where('mahasiswa_id', $mahasiswa->id)
                          ->where('mata_kuliah_id', $validated['mata_kuliah_id'])
                          ->first();

        if ($existingKrs) {
            return back()->withErrors(['mata_kuliah_id' => 'Anda sudah terdaftar untuk mata kuliah ini']);
        }

        Krs::create([
            'mahasiswa_id' => $mahasiswa->id,
            'mata_kuliah_id' => $validated['mata_kuliah_id'],
            'dosen_id' => $validated['dosen_id'],
            'tahun_akademik' => $validated['tahun_akademik'],
            'semester' => $validated['semester'],
            'status' => 'pending',
        ]);

        return redirect()->route('mahasiswa.krs.index')->with('success', 'KRS berhasil diajukan');
    }

    // Dosen methods
    public function dosenIndex()
    {
        $user = Auth::user();
        $dosen = $user->dosen;
        $krss = Krs::where('dosen_id', $dosen->id)
                   ->with(['mahasiswa', 'mataKuliah'])
                   ->paginate(10);
        return view('dosen.krs.index', compact('krss'));
    }
}
