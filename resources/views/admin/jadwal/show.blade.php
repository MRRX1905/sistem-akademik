@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detail Jadwal Kuliah</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $jadwal->mataKuliah->nama_mk ?? '-' }}</h5>
            <p class="card-text"><strong>Hari:</strong> {{ $jadwal->hari }}</p>
            <p class="card-text"><strong>Jam:</strong> {{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}</p>
            <p class="card-text"><strong>Dosen:</strong> {{ $jadwal->dosen->nama ?? '-' }}</p>
            <p class="card-text"><strong>Ruang:</strong> {{ $jadwal->ruang }}</p>
            <p class="card-text"><strong>Semester:</strong> {{ $jadwal->semester }}</p>
        </div>
    </div>
    <a href="{{ route('jadwal.index') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection 