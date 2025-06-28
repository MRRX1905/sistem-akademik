@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detail Mahasiswa</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $mahasiswa->nama_lengkap }}</h5>
            <p class="card-text"><strong>NIM:</strong> {{ $mahasiswa->nim }}</p>
            <p class="card-text"><strong>Tempat Lahir:</strong> {{ $mahasiswa->tempat_lahir }}</p>
            <p class="card-text"><strong>Tanggal Lahir:</strong> {{ $mahasiswa->tanggal_lahir->format('d/m/Y') }}</p>
            <p class="card-text"><strong>Jenis Kelamin:</strong> {{ $mahasiswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
            <p class="card-text"><strong>Alamat:</strong> {{ $mahasiswa->alamat }}</p>
            <p class="card-text"><strong>No HP:</strong> {{ $mahasiswa->no_hp }}</p>
            <p class="card-text"><strong>Program Studi:</strong> {{ $mahasiswa->program_studi }}</p>
            <p class="card-text"><strong>Angkatan:</strong> {{ $mahasiswa->angkatan }}</p>
            <p class="card-text"><strong>Status:</strong> 
                <span class="badge bg-{{ $mahasiswa->status == 'aktif' ? 'success' : 'danger' }}">
                    {{ ucfirst($mahasiswa->status) }}
                </span>
            </p>
        </div>
    </div>
    <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection 