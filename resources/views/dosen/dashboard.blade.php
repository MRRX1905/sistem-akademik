@extends('layouts.app')

@section('title', 'Dashboard Dosen')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard Dosen</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <span class="text-muted">Selamat datang, {{ $dosen->nama_lengkap }}!</span>
        </div>
    </div>
</div>

<!-- Dosen Information -->
<div class="row mb-4">
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-user me-2"></i>Informasi Dosen</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>NIP:</strong> {{ $dosen->nip }}</p>
                        <p><strong>Nama Lengkap:</strong> {{ $dosen->nama_lengkap }}</p>
                        <p><strong>Tempat, Tanggal Lahir:</strong> {{ $dosen->tempat_lahir }}, {{ $dosen->tanggal_lahir->format('d/m/Y') }}</p>
                        <p><strong>Jenis Kelamin:</strong> {{ $dosen->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Alamat:</strong> {{ $dosen->alamat }}</p>
                        <p><strong>No. HP:</strong> {{ $dosen->no_hp }}</p>
                        <p><strong>Bidang Keahlian:</strong> {{ $dosen->bidang_keahlian }}</p>
                        <p><strong>Status:</strong> 
                            <span class="badge bg-{{ $dosen->status == 'aktif' ? 'success' : 'danger' }}">
                                {{ ucfirst($dosen->status) }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="row">
            <div class="col-12 mb-3">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total KRS</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalKrs }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-12">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Total Nilai</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalNilai }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-star fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-tasks me-2"></i>Aksi Cepat</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <a href="{{ route('dosen.krs.index') }}" class="btn btn-primary btn-block w-100">
                            <i class="fas fa-clipboard-list me-2"></i>Lihat KRS
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="{{ route('dosen.nilai.index') }}" class="btn btn-success btn-block w-100">
                            <i class="fas fa-star me-2"></i>Input Nilai
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="#" class="btn btn-info btn-block w-100">
                            <i class="fas fa-chart-bar me-2"></i>Laporan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activities -->
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-history me-2"></i>Aktivitas Terbaru</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Aktivitas</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ now()->format('d/m/Y H:i') }}</td>
                                <td>Login ke sistem akademik</td>
                                <td><span class="badge bg-success">Berhasil</span></td>
                            </tr>
                            <tr>
                                <td>{{ now()->subHours(1)->format('d/m/Y H:i') }}</td>
                                <td>Mengakses dashboard dosen</td>
                                <td><span class="badge bg-info">Info</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 