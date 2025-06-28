@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Jadwal Kuliah</h1>
    <div class="mb-3">
        <a href="{{ route('jadwal.create') }}" class="btn btn-primary">Tambah Jadwal</a>
        <a href="{{ route('jadwal.export-pdf') }}" class="btn btn-success">Export PDF</a>
    </div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    <!-- Search and Filter Form -->
    <div class="card mb-3">
        <div class="card-header">
            <h5 class="mb-0">Pencarian & Filter</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('jadwal.index') }}">
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <label for="hari" class="form-label">Hari</label>
                        <input type="text" name="hari" id="hari" class="form-control" value="{{ request('hari') }}" placeholder="Contoh: Senin">
                    </div>
                    <div class="col-md-3 mb-2">
                        <label for="mata_kuliah" class="form-label">Mata Kuliah</label>
                        <input type="text" name="mata_kuliah" id="mata_kuliah" class="form-control" value="{{ request('mata_kuliah') }}" placeholder="Nama mata kuliah">
                    </div>
                    <div class="col-md-3 mb-2">
                        <label for="dosen" class="form-label">Dosen</label>
                        <input type="text" name="dosen" id="dosen" class="form-control" value="{{ request('dosen') }}" placeholder="Nama dosen">
                    </div>
                    <div class="col-md-3 mb-2">
                        <label for="semester" class="form-label">Semester</label>
                        <input type="text" name="semester" id="semester" class="form-control" value="{{ request('semester') }}" placeholder="Contoh: 1, 2, 3">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Cari</button>
                        <a href="{{ route('jadwal.index') }}" class="btn btn-secondary">Reset</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Hari</th>
                <th>Jam</th>
                <th>Mata Kuliah</th>
                <th>Dosen</th>
                <th>Ruang</th>
                <th>Semester</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jadwals as $jadwal)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $jadwal->hari }}</td>
                <td>{{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}</td>
                <td>{{ $jadwal->mataKuliah->nama_mk ?? '-' }}</td>
                <td>{{ $jadwal->dosen->nama ?? '-' }}</td>
                <td>{{ $jadwal->ruang }}</td>
                <td>{{ $jadwal->semester }}</td>
                <td>
                    <a href="{{ route('jadwal.show', $jadwal) }}" class="btn btn-info btn-sm">Detail</a>
                    <a href="{{ route('jadwal.edit', $jadwal) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('jadwal.destroy', $jadwal) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus jadwal?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $jadwals->links() }}
</div>
@endsection 