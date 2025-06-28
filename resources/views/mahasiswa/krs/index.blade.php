@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Kartu Rencana Studi (KRS)</h5>
                    <a href="{{ route('mahasiswa.krs.create') }}" class="btn btn-success">Ambil Mata Kuliah</a>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($krss->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Mata Kuliah</th>
                                        <th>Dosen</th>
                                        <th>Tahun Akademik</th>
                                        <th>Semester</th>
                                        <th>Status</th>
                                        <th>Tanggal Pengajuan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($krss as $index => $krs)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <strong>{{ $krs->mataKuliah->kode_mk }}</strong><br>
                                            <small>{{ $krs->mataKuliah->nama_mk }}</small><br>
                                            <span class="badge bg-secondary">{{ $krs->mataKuliah->sks }} SKS</span>
                                        </td>
                                        <td>{{ $krs->dosen->nama_lengkap }}</td>
                                        <td>{{ $krs->tahun_akademik }}</td>
                                        <td>{{ $krs->semester }}</td>
                                        <td>
                                            @if($krs->status == 'pending')
                                                <span class="badge bg-warning">Pending</span>
                                            @elseif($krs->status == 'disetujui')
                                                <span class="badge bg-success">Disetujui</span>
                                            @else
                                                <span class="badge bg-danger">Ditolak</span>
                                            @endif
                                        </td>
                                        <td>{{ $krs->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="d-flex justify-content-center">
                            {{ $krss->links() }}
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Belum ada KRS</h5>
                            <p class="text-muted">Anda belum mengambil mata kuliah apapun.</p>
                            <a href="{{ route('mahasiswa.krs.create') }}" class="btn btn-primary">Ambil Mata Kuliah Pertama</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 