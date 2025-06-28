@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar KRS</h1>
    <div class="mb-3">
        <a href="{{ route('krs.create') }}" class="btn btn-primary">Tambah KRS</a>
    </div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Mahasiswa</th>
                <th>Mata Kuliah</th>
                <th>Dosen</th>
                <th>Tahun Akademik</th>
                <th>Semester</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($krss as $krs)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $krs->mahasiswa->nama_lengkap ?? '-' }}</td>
                <td>{{ $krs->mataKuliah->nama_mk ?? '-' }}</td>
                <td>{{ $krs->dosen->nama_lengkap ?? '-' }}</td>
                <td>{{ $krs->tahun_akademik }}</td>
                <td>{{ $krs->semester }}</td>
                <td>
                    <span class="badge bg-{{ $krs->status == 'aktif' ? 'success' : 'danger' }}">
                        {{ ucfirst($krs->status) }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('krs.show', $krs) }}" class="btn btn-info btn-sm">Detail</a>
                    <a href="{{ route('krs.edit', $krs) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('krs.destroy', $krs) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus KRS?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $krss->links() }}
</div>
@endsection 