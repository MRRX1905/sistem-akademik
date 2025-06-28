@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Nilai</h1>
    <form action="{{ route('nilai.update', $nilai) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="krs_id" class="form-label">KRS</label>
            <select name="krs_id" id="krs_id" class="form-control" required>
                <option value="">Pilih KRS</option>
                @foreach($krss as $krs)
                    <option value="{{ $krs->id }}" {{ old('krs_id', $nilai->krs_id) == $krs->id ? 'selected' : '' }}>
                        {{ $krs->mahasiswa->nama_lengkap ?? '-' }} - {{ $krs->mataKuliah->nama_mk ?? '-' }}
                    </option>
                @endforeach
            </select>
            @error('krs_id')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label for="mahasiswa_id" class="form-label">Mahasiswa</label>
            <select name="mahasiswa_id" id="mahasiswa_id" class="form-control" required>
                <option value="">Pilih Mahasiswa</option>
                @foreach($mahasiswas as $mahasiswa)
                    <option value="{{ $mahasiswa->id }}" {{ old('mahasiswa_id', $nilai->mahasiswa_id) == $mahasiswa->id ? 'selected' : '' }}>
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
                    <option value="{{ $mataKuliah->id }}" {{ old('mata_kuliah_id', $nilai->mata_kuliah_id) == $mataKuliah->id ? 'selected' : '' }}>
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
                    <option value="{{ $dosen->id }}" {{ old('dosen_id', $nilai->dosen_id) == $dosen->id ? 'selected' : '' }}>
                        {{ $dosen->nip }} - {{ $dosen->nama_lengkap }}
                    </option>
                @endforeach
            </select>
            @error('dosen_id')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label for="nilai_tugas" class="form-label">Nilai Tugas</label>
            <input type="number" name="nilai_tugas" id="nilai_tugas" class="form-control" value="{{ old('nilai_tugas', $nilai->nilai_tugas) }}" min="0" max="100" step="0.01">
            @error('nilai_tugas')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label for="nilai_uts" class="form-label">Nilai UTS</label>
            <input type="number" name="nilai_uts" id="nilai_uts" class="form-control" value="{{ old('nilai_uts', $nilai->nilai_uts) }}" min="0" max="100" step="0.01">
            @error('nilai_uts')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label for="nilai_uas" class="form-label">Nilai UAS</label>
            <input type="number" name="nilai_uas" id="nilai_uas" class="form-control" value="{{ old('nilai_uas', $nilai->nilai_uas) }}" min="0" max="100" step="0.01">
            @error('nilai_uas')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label for="nilai_akhir" class="form-label">Nilai Akhir</label>
            <input type="number" name="nilai_akhir" id="nilai_akhir" class="form-control" value="{{ old('nilai_akhir', $nilai->nilai_akhir) }}" min="0" max="100" step="0.01">
            @error('nilai_akhir')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label for="grade" class="form-label">Grade</label>
            <select name="grade" id="grade" class="form-control">
                <option value="">Pilih Grade</option>
                <option value="A" {{ old('grade', $nilai->grade) == 'A' ? 'selected' : '' }}>A</option>
                <option value="B" {{ old('grade', $nilai->grade) == 'B' ? 'selected' : '' }}>B</option>
                <option value="C" {{ old('grade', $nilai->grade) == 'C' ? 'selected' : '' }}>C</option>
                <option value="D" {{ old('grade', $nilai->grade) == 'D' ? 'selected' : '' }}>D</option>
                <option value="E" {{ old('grade', $nilai->grade) == 'E' ? 'selected' : '' }}>E</option>
            </select>
            @error('grade')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label for="catatan" class="form-label">Catatan</label>
            <textarea name="catatan" id="catatan" class="form-control" rows="3">{{ old('catatan', $nilai->catatan) }}</textarea>
            @error('catatan')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('nilai.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection 