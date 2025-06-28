@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detail Dosen</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $dosen->nama_lengkap }}</h5>
            <p class="card-text"><strong>NIP:</strong> {{ $dosen->nip }}</p>
            <p class="card-text"><strong>Tempat Lahir:</strong> {{ $dosen->tempat_lahir }}</p>
            <p class="card-text"><strong>Tanggal Lahir:</strong> {{ $dosen->tanggal_lahir->format('d/m/Y') }}</p>
            <p class="card-text"><strong>Jenis Kelamin:</strong> {{ $dosen->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
            <p class="card-text"><strong>Alamat:</strong> {{ $dosen->alamat }}</p>
            <p class="card-text"><strong>No HP:</strong> {{ $dosen->no_hp }}</p>
            <p class="card-text"><strong>Bidang Keahlian:</strong> {{ $dosen->bidang_keahlian }}</p>
            <p class="card-text"><strong>Status:</strong> 
                <span class="badge bg-{{ $dosen->status == 'aktif' ? 'success' : 'danger' }}">
                    {{ ucfirst($dosen->status) }}
                </span>
            </p>
        </div>
    </div>
    <a href="{{ route('dosen.index') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection 