@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detail KRS</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Kartu Rencana Studi</h5>
            <p class="card-text"><strong>Mahasiswa:</strong> {{ $krs->mahasiswa->nama_lengkap ?? '-' }} ({{ $krs->mahasiswa->nim ?? '-' }})</p>
            <p class="card-text"><strong>Mata Kuliah:</strong> {{ $krs->mataKuliah->nama_mk ?? '-' }} ({{ $krs->mataKuliah->kode_mk ?? '-' }})</p>
            <p class="card-text"><strong>Dosen:</strong> {{ $krs->dosen->nama_lengkap ?? '-' }} ({{ $krs->dosen->nip ?? '-' }})</p>
            <p class="card-text"><strong>Tahun Akademik:</strong> {{ $krs->tahun_akademik }}</p>
            <p class="card-text"><strong>Semester:</strong> {{ $krs->semester }}</p>
            <p class="card-text"><strong>Status:</strong> 
                <span class="badge bg-{{ $krs->status == 'aktif' ? 'success' : 'danger' }}">
                    {{ ucfirst($krs->status) }}
                </span>
            </p>
        </div>
    </div>
    <a href="{{ route('krs.index') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection 