@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detail Mata Kuliah</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $mataKuliah->nama_mk }}</h5>
            <p class="card-text"><strong>Kode Mata Kuliah:</strong> {{ $mataKuliah->kode_mk }}</p>
            <p class="card-text"><strong>SKS:</strong> {{ $mataKuliah->sks }}</p>
            <p class="card-text"><strong>Semester:</strong> {{ $mataKuliah->semester }}</p>
            <p class="card-text"><strong>Program Studi:</strong> {{ $mataKuliah->program_studi }}</p>
            <p class="card-text"><strong>Deskripsi:</strong> {{ $mataKuliah->deskripsi ?: 'Tidak ada deskripsi' }}</p>
            <p class="card-text"><strong>Status:</strong> 
                <span class="badge bg-{{ $mataKuliah->status == 'aktif' ? 'success' : 'danger' }}">
                    {{ ucfirst($mataKuliah->status) }}
                </span>
            </p>
        </div>
    </div>
    <a href="{{ route('mata-kuliah.index') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection 