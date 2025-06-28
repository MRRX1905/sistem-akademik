@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Jadwal Kuliah Saya</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Hari</th>
                <th>Jam</th>
                <th>Mata Kuliah</th>
                <th>Ruang</th>
                <th>Semester</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jadwals as $jadwal)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $jadwal->hari }}</td>
                <td>{{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}</td>
                <td>{{ $jadwal->mataKuliah->nama_mk ?? '-' }}</td>
                <td>{{ $jadwal->ruang }}</td>
                <td>{{ $jadwal->semester }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection 