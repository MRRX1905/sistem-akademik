@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Nilai</h1>
    <div class="mb-3">
        <a href="{{ route('nilai.create') }}" class="btn btn-primary">Tambah Nilai</a>
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
                <th>Nilai Tugas</th>
                <th>Nilai UTS</th>
                <th>Nilai UAS</th>
                <th>Nilai Akhir</th>
                <th>Grade</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($nilais as $nilai)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $nilai->mahasiswa->nama_lengkap ?? '-' }}</td>
                <td>{{ $nilai->mataKuliah->nama_mk ?? '-' }}</td>
                <td>{{ $nilai->dosen->nama_lengkap ?? '-' }}</td>
                <td>{{ $nilai->nilai_tugas ?? '-' }}</td>
                <td>{{ $nilai->nilai_uts ?? '-' }}</td>
                <td>{{ $nilai->nilai_uas ?? '-' }}</td>
                <td>{{ $nilai->nilai_akhir ?? '-' }}</td>
                <td>
                    <span class="badge bg-{{ $nilai->grade == 'A' ? 'success' : ($nilai->grade == 'B' ? 'info' : ($nilai->grade == 'C' ? 'warning' : 'danger')) }}">
                        {{ $nilai->grade ?? '-' }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('nilai.show', $nilai) }}" class="btn btn-info btn-sm">Detail</a>
                    <a href="{{ route('nilai.edit', $nilai) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('nilai.destroy', $nilai) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus nilai?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $nilais->links() }}
</div>
@endsection 