@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tambah KRS</h1>
    <form action="{{ route('krs.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="mahasiswa_id" class="form-label">Mahasiswa</label>
            <select name="mahasiswa_id" id="mahasiswa_id" class="form-control" required>
                <option value="">Pilih Mahasiswa</option>
                @foreach($mahasiswas as $mahasiswa)
                    <option value="{{ $mahasiswa->id }}" {{ old('mahasiswa_id') == $mahasiswa->id ? 'selected' : '' }}>
                        {{ $mahasiswa->nim }} - {{ $mahasiswa->nama_lengkap }}
                    </option>
                @endforeach
            </select>
            @error('mahasiswa_id')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label for="mata_kuliah_id" class="form-label">Mata Kuliah</label>
            <select name="mata_kuliah_id" id="mata_kuliah_id" class="form-control" required>
                <option value="">Pilih Mata Kuliah</option>
                @foreach($mataKuliahs as $mataKuliah)
                    <option value="{{ $mataKuliah->id }}" {{ old('mata_kuliah_id') == $mataKuliah->id ? 'selected' : '' }}>
                        {{ $mataKuliah->kode_mk }} - {{ $mataKuliah->nama_mk }}
                    </option>
                @endforeach
            </select>
            @error('mata_kuliah_id')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label for="dosen_id" class="form-label">Dosen</label>
            <select name="dosen_id" id="dosen_id" class="form-control" required>
                <option value="">Pilih Dosen</option>
                @foreach($dosens as $dosen)
                    <option value="{{ $dosen->id }}" {{ old('dosen_id') == $dosen->id ? 'selected' : '' }}>
                        {{ $dosen->nip }} - {{ $dosen->nama_lengkap }}
                    </option>
                @endforeach
            </select>
            @error('dosen_id')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label for="tahun_akademik" class="form-label">Tahun Akademik</label>
            <input type="text" name="tahun_akademik" id="tahun_akademik" class="form-control" value="{{ old('tahun_akademik', date('Y')) }}" placeholder="Contoh: 2024/2025" required>
            @error('tahun_akademik')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label for="semester" class="form-label">Semester</label>
            <select name="semester" id="semester" class="form-control" required>
                <option value="">Pilih Semester</option>
                <option value="Ganjil" {{ old('semester') == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                <option value="Genap" {{ old('semester') == 'Genap' ? 'selected' : '' }}>Genap</option>
                <option value="Pendek" {{ old('semester') == 'Pendek' ? 'selected' : '' }}>Pendek</option>
            </select>
            @error('semester')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-control" required>
                <option value="">Pilih Status</option>
                <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
            </select>
            @error('status')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('krs.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection 