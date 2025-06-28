@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard Admin</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <span class="text-muted">Selamat datang, {{ auth()->user()->name }}!</span>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Mahasiswa</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalMahasiswa }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-graduate fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total Dosen</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalDosen }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-chalkboard-teacher fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Total Mata Kuliah</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalMataKuliah }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-book fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
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

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                            Total Jadwal</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalJadwal }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-secondary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                            Rata-rata Nilai</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($rataRataNilai, 2) }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row">
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Manajemen Data</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <a href="{{ route('users.create') }}" class="btn btn-dark btn-block w-100">
                            <i class="fas fa-user-plus me-2"></i>Tambah User
                        </a>
                    </div>
                    <div class="col-md-6 mb-3">
                        <a href="{{ route('mahasiswa.create') }}" class="btn btn-primary btn-block w-100">
                            <i class="fas fa-plus me-2"></i>Tambah Mahasiswa
                        </a>
                    </div>
                    <div class="col-md-6 mb-3">
                        <a href="{{ route('dosen.create') }}" class="btn btn-success btn-block w-100">
                            <i class="fas fa-plus me-2"></i>Tambah Dosen
                        </a>
                    </div>
                    <div class="col-md-6 mb-3">
                        <a href="{{ route('mata-kuliah.create') }}" class="btn btn-info btn-block w-100">
                            <i class="fas fa-plus me-2"></i>Tambah Mata Kuliah
                        </a>
                    </div>
                    <div class="col-md-6 mb-3">
                        <a href="{{ route('krs.create') }}" class="btn btn-warning btn-block w-100">
                            <i class="fas fa-plus me-2"></i>Tambah KRS
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Lihat Data</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <a href="{{ route('users.index') }}" class="btn btn-outline-dark btn-block w-100">
                            <i class="fas fa-users me-2"></i>Data User
                        </a>
                    </div>
                    <div class="col-md-6 mb-3">
                        <a href="{{ route('mahasiswa.index') }}" class="btn btn-outline-primary btn-block w-100">
                            <i class="fas fa-list me-2"></i>Data Mahasiswa
                        </a>
                    </div>
                    <div class="col-md-6 mb-3">
                        <a href="{{ route('dosen.index') }}" class="btn btn-outline-success btn-block w-100">
                            <i class="fas fa-list me-2"></i>Data Dosen
                        </a>
                    </div>
                    <div class="col-md-6 mb-3">
                        <a href="{{ route('mata-kuliah.index') }}" class="btn btn-outline-info btn-block w-100">
                            <i class="fas fa-list me-2"></i>Data Mata Kuliah
                        </a>
                    </div>
                    <div class="col-md-6 mb-3">
                        <a href="{{ route('krs.index') }}" class="btn btn-outline-warning btn-block w-100">
                            <i class="fas fa-list me-2"></i>Data KRS
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts -->
<div class="row">
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Distribusi Grade</h6>
            </div>
            <div class="card-body">
                <canvas id="gradeChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Statistik Nilai</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Grade</th>
                                <th>Jumlah</th>
                                <th>Persentase</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $totalNilai = \App\Models\Nilai::count();
                            @endphp
                            @foreach($distribusiGrade as $grade => $jumlah)
                            <tr>
                                <td>{{ $grade }}</td>
                                <td>{{ $jumlah }}</td>
                                <td>{{ $totalNilai > 0 ? number_format(($jumlah / $totalNilai) * 100, 1) : 0 }}%</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activities -->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Aktivitas Terbaru</h6>
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
                                <td>Sistem Akademik berhasil diaktifkan</td>
                                <td><span class="badge bg-success">Berhasil</span></td>
                            </tr>
                            <tr>
                                <td>{{ now()->subHours(2)->format('d/m/Y H:i') }}</td>
                                <td>Database telah dibuat dan siap digunakan</td>
                                <td><span class="badge bg-success">Berhasil</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('gradeChart').getContext('2d');
    const gradeData = @json($distribusiGrade);
    
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: Object.keys(gradeData),
            datasets: [{
                data: Object.values(gradeData),
                backgroundColor: [
                    '#28a745', // A - Hijau
                    '#17a2b8', // B - Biru
                    '#ffc107', // C - Kuning
                    '#fd7e14', // D - Orange
                    '#dc3545'  // E - Merah
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                },
                title: {
                    display: true,
                    text: 'Distribusi Grade Mahasiswa'
                }
            }
        }
    });
});
</script>
@endpush 