@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Ambil Mata Kuliah</h5>
                </div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('mahasiswa.krs.store') }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="mata_kuliah_id" class="form-label">Mata Kuliah <span class="text-danger">*</span></label>
                            <select class="form-select @error('mata_kuliah_id') is-invalid @enderror" id="mata_kuliah_id" name="mata_kuliah_id" required>
                                <option value="">Pilih Mata Kuliah</option>
                                @foreach($mataKuliahs as $mataKuliah)
                                    <option value="{{ $mataKuliah->id }}" {{ old('mata_kuliah_id') == $mataKuliah->id ? 'selected' : '' }}>
                                        {{ $mataKuliah->kode_mk }} - {{ $mataKuliah->nama_mk }} ({{ $mataKuliah->sks }} SKS)
                                    </option>
                                @endforeach
                            </select>
                            @error('mata_kuliah_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="dosen_id" class="form-label">Dosen <span class="text-danger">*</span></label>
                            <select class="form-select @error('dosen_id') is-invalid @enderror" id="dosen_id" name="dosen_id" required>
                                <option value="">Pilih Dosen</option>
                                @foreach($dosens as $dosen)
                                    <option value="{{ $dosen->id }}" {{ old('dosen_id') == $dosen->id ? 'selected' : '' }}>
                                        {{ $dosen->nama_lengkap }} - {{ $dosen->bidang_keahlian }}
                                    </option>
                                @endforeach
                            </select>
                            @error('dosen_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tahun_akademik" class="form-label">Tahun Akademik <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('tahun_akademik') is-invalid @enderror" 
                                   id="tahun_akademik" name="tahun_akademik" 
                                   value="{{ old('tahun_akademik', date('Y') . '/' . (date('Y') + 1)) }}" 
                                   placeholder="Contoh: 2024/2025" required>
                            @error('tahun_akademik')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="semester" class="form-label">Semester <span class="text-danger">*</span></label>
                            <select class="form-select @error('semester') is-invalid @enderror" id="semester" name="semester" required>
                                <option value="">Pilih Semester</option>
                                <option value="Ganjil" {{ old('semester') == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                                <option value="Genap" {{ old('semester') == 'Genap' ? 'selected' : '' }}>Genap</option>
                                <option value="Pendek" {{ old('semester') == 'Pendek' ? 'selected' : '' }}>Pendek</option>
                            </select>
                            @error('semester')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('mahasiswa.krs.index') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Ajukan KRS</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 