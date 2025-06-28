@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Mata Kuliah</h1>
    <div class="mb-3">
        <a href="{{ route('mata-kuliah.create') }}" class="btn btn-primary">Tambah Mata Kuliah</a>
    </div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode MK</th>
                <th>Nama Mata Kuliah</th>
                <th>SKS</th>
                <th>Semester</th>
                <th>Program Studi</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($mataKuliahs as $mataKuliah)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $mataKuliah->kode_mk }}</td>
                <td>{{ $mataKuliah->nama_mk }}</td>
                <td>{{ $mataKuliah->sks }}</td>
                <td>{{ $mataKuliah->semester }}</td>
                <td>{{ $mataKuliah->program_studi }}</td>
                <td>
                    <span class="badge bg-{{ $mataKuliah->status == 'aktif' ? 'success' : 'danger' }}">
                        {{ ucfirst($mataKuliah->status) }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('mata-kuliah.show', $mataKuliah) }}" class="btn btn-info btn-sm">Detail</a>
                    <a href="{{ route('mata-kuliah.edit', $mataKuliah) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('mata-kuliah.destroy', $mataKuliah) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus mata kuliah?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $mataKuliahs->links() }}
</div>
@endsection 