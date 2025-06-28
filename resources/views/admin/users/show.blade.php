@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Detail User</h1>
        <div>
            <a href="{{ route('users.edit', $user) }}" class="btn btn-warning">
                <i class="fas fa-edit me-2"></i>Edit User
            </a>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-user me-2"></i>Informasi User
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="150" class="fw-bold">Nama Lengkap</td>
                                    <td>: {{ $user->name }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Username</td>
                                    <td>: {{ $user->username }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Email</td>
                                    <td>: {{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Role</td>
                                    <td>: 
                                        <span class="badge bg-{{ $user->role == 'admin' ? 'danger' : ($user->role == 'dosen' ? 'info' : 'success') }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Status</td>
                                    <td>: 
                                        <span class="badge bg-success">Aktif</span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="150" class="fw-bold">Tanggal Dibuat</td>
                                    <td>: {{ $user->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Terakhir Update</td>
                                    <td>: {{ $user->updated_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Email Verified</td>
                                    <td>: 
                                        @if($user->email_verified_at)
                                            <span class="badge bg-success">
                                                <i class="fas fa-check me-1"></i>Verified
                                            </span>
                                        @else
                                            <span class="badge bg-warning">
                                                <i class="fas fa-clock me-1"></i>Pending
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-user-circle me-2"></i>Avatar
                    </h5>
                </div>
                <div class="card-body text-center">
                    <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 100px; height: 100px;">
                        <i class="fas fa-user fa-3x text-primary"></i>
                    </div>
                    <h6 class="mb-1">{{ $user->name }}</h6>
                    <p class="text-muted mb-0">{{ ucfirst($user->role) }}</p>
                </div>
            </div>
        </div>
    </div>

    @if($user->role == 'mahasiswa' && $user->mahasiswa)
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-user-graduate me-2"></i>Informasi Mahasiswa
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="150" class="fw-bold">NIM</td>
                                    <td>: <span class="badge bg-light text-dark">{{ $user->mahasiswa->nim }}</span></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Program Studi</td>
                                    <td>: {{ $user->mahasiswa->program_studi }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Angkatan</td>
                                    <td>: {{ $user->mahasiswa->angkatan }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Status</td>
                                    <td>: 
                                        <span class="badge bg-{{ $user->mahasiswa->status == 'aktif' ? 'success' : 'secondary' }}">
                                            {{ ucfirst($user->mahasiswa->status) }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="150" class="fw-bold">Tempat Lahir</td>
                                    <td>: {{ $user->mahasiswa->tempat_lahir }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Tanggal Lahir</td>
                                    <td>: {{ $user->mahasiswa->tanggal_lahir->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Jenis Kelamin</td>
                                    <td>: {{ $user->mahasiswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">No. HP</td>
                                    <td>: {{ $user->mahasiswa->no_hp }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="150" class="fw-bold">Alamat</td>
                                    <td>: {{ $user->mahasiswa->alamat }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if($user->role == 'dosen' && $user->dosen)
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-chalkboard-teacher me-2"></i>Informasi Dosen
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="150" class="fw-bold">NIP</td>
                                    <td>: <span class="badge bg-light text-dark">{{ $user->dosen->nip }}</span></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Bidang Keahlian</td>
                                    <td>: {{ $user->dosen->bidang_keahlian }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Pendidikan Terakhir</td>
                                    <td>: {{ $user->dosen->pendidikan_terakhir }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Status</td>
                                    <td>: 
                                        <span class="badge bg-{{ $user->dosen->status == 'aktif' ? 'success' : 'secondary' }}">
                                            {{ ucfirst($user->dosen->status) }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="150" class="fw-bold">Tempat Lahir</td>
                                    <td>: {{ $user->dosen->tempat_lahir }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Tanggal Lahir</td>
                                    <td>: {{ $user->dosen->tanggal_lahir->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Jenis Kelamin</td>
                                    <td>: {{ $user->dosen->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">No. HP</td>
                                    <td>: {{ $user->dosen->no_hp }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="150" class="fw-bold">Alamat</td>
                                    <td>: {{ $user->dosen->alamat }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection 