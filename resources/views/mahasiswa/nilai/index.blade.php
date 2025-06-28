@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Nilai Akademik</h5>
                </div>

                <div class="card-body">
                    @if($nilais->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Mata Kuliah</th>
                                        <th>Dosen</th>
                                        <th>Nilai Tugas</th>
                                        <th>Nilai UTS</th>
                                        <th>Nilai UAS</th>
                                        <th>Nilai Akhir</th>
                                        <th>Grade</th>
                                        <th>Catatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($nilais as $index => $nilai)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <strong>{{ $nilai->mataKuliah->kode_mk }}</strong><br>
                                            <small>{{ $nilai->mataKuliah->nama_mk }}</small><br>
                                            <span class="badge bg-secondary">{{ $nilai->mataKuliah->sks }} SKS</span>
                                        </td>
                                        <td>{{ $nilai->dosen->nama_lengkap }}</td>
                                        <td>{{ $nilai->nilai_tugas }}</td>
                                        <td>{{ $nilai->nilai_uts }}</td>
                                        <td>{{ $nilai->nilai_uas }}</td>
                                        <td>
                                            <strong>{{ $nilai->nilai_akhir }}</strong>
                                        </td>
                                        <td>
                                            @if($nilai->grade == 'A')
                                                <span class="badge bg-success">{{ $nilai->grade }}</span>
                                            @elseif($nilai->grade == 'B')
                                                <span class="badge bg-primary">{{ $nilai->grade }}</span>
                                            @elseif($nilai->grade == 'C')
                                                <span class="badge bg-warning">{{ $nilai->grade }}</span>
                                            @elseif($nilai->grade == 'D')
                                                <span class="badge bg-danger">{{ $nilai->grade }}</span>
                                            @else
                                                <span class="badge bg-dark">{{ $nilai->grade }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($nilai->catatan)
                                                <small class="text-muted">{{ $nilai->catatan }}</small>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="d-flex justify-content-center">
                            {{ $nilais->links() }}
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-star fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Belum ada nilai</h5>
                            <p class="text-muted">Nilai mata kuliah Anda akan muncul di sini setelah dosen menginput nilai.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 