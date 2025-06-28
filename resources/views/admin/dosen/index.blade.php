@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Dosen</h1>
    <div class="mb-3">
        <a href="{{ route('dosen.create') }}" class="btn btn-primary">Tambah Dosen</a>
    </div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>NIP</th>
                <th>Nama Lengkap</th>
                <th>Bidang Keahlian</th>
                <th>No HP</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dosens as $dosen)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $dosen->nip }}</td>
                <td>{{ $dosen->nama_lengkap }}</td>
                <td>{{ $dosen->bidang_keahlian }}</td>
                <td>{{ $dosen->no_hp }}</td>
                <td>
                    <span class="badge bg-{{ $dosen->status == 'aktif' ? 'success' : 'danger' }}">
                        {{ ucfirst($dosen->status) }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('dosen.show', $dosen) }}" class="btn btn-info btn-sm">Detail</a>
                    <a href="{{ route('dosen.edit', $dosen) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('dosen.destroy', $dosen) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus dosen?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $dosens->links() }}
</div>
@endsection 