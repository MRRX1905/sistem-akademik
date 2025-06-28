@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detail Nilai</h1>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5>Informasi Mahasiswa</h5>
                    <table class="table table-borderless">
                        <tr>
                            <td width="150">NIM</td>
                            <td>: {{ $nilai->mahasiswa->nim ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Nama Lengkap</td>
                            <td>: {{ $nilai->mahasiswa->nama_lengkap ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Program Studi</td>
                            <td>: {{ $nilai->mahasiswa->program_studi ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h5>Informasi Mata Kuliah</h5>
                    <table class="table table-borderless">
                        <tr>
                            <td width="150">Kode MK</td>
                            <td>: {{ $nilai->mataKuliah->kode_mk ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Nama Mata Kuliah</td>
                            <td>: {{ $nilai->mataKuliah->nama_mk ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>SKS</td>
                            <td>: {{ $nilai->mataKuliah->sks ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <h5>Informasi Dosen</h5>
                    <table class="table table-borderless">
                        <tr>
                            <td width="150">NIP</td>
                            <td>: {{ $nilai->dosen->nip ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Nama Lengkap</td>
                            <td>: {{ $nilai->dosen->nama_lengkap ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Bidang</td>
                            <td>: {{ $nilai->dosen->bidang ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h5>Nilai</h5>
                    <table class="table table-borderless">
                        <tr>
                            <td width="150">Nilai Tugas</td>
                            <td>: {{ $nilai->nilai_tugas ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Nilai UTS</td>
                            <td>: {{ $nilai->nilai_uts ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Nilai UAS</td>
                            <td>: {{ $nilai->nilai_uas ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Nilai Akhir</td>
                            <td>: {{ $nilai->nilai_akhir ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Grade</td>
                            <td>: 
                                <span class="badge bg-{{ $nilai->grade == 'A' ? 'success' : ($nilai->grade == 'B' ? 'info' : ($nilai->grade == 'C' ? 'warning' : 'danger')) }}">
                                    {{ $nilai->grade ?? '-' }}
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            @if($nilai->catatan)
            <hr>
            <div class="row">
                <div class="col-12">
                    <h5>Catatan</h5>
                    <p>{{ $nilai->catatan }}</p>
                </div>
            </div>
            @endif
        </div>
    </div>
    <div class="mt-3">
        <a href="{{ route('nilai.edit', $nilai) }}" class="btn btn-warning">Edit</a>
        <a href="{{ route('nilai.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
@endsection 