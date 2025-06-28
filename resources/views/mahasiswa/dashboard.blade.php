@extends('layouts.app')

@section('title', 'Dashboard Mahasiswa')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard Mahasiswa') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h4>Selamat datang, {{ Auth::user()->name }}!</h4>
                    
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Kartu Rencana Studi (KRS)</h5>
                                    <p class="card-text">Kelola pengambilan mata kuliah Anda</p>
                                    <a href="{{ route('mahasiswa.krs.index') }}" class="btn btn-primary">Lihat KRS</a>
                                    <a href="{{ route('mahasiswa.krs.create') }}" class="btn btn-success">Ambil Mata Kuliah</a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Nilai Akademik</h5>
                                    <p class="card-text">Lihat nilai mata kuliah Anda</p>
                                    <a href="{{ route('mahasiswa.nilai.index') }}" class="btn btn-info">Lihat Nilai</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 