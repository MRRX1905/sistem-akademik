<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\MataKuliahController;
use App\Http\Controllers\KrsController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Password Reset Routes
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    // Dashboard Routes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Admin Routes
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');
        
        // User Management
        Route::resource('users', UserController::class);
        
        // Mahasiswa Management
        Route::resource('mahasiswa', MahasiswaController::class);
        
        // Dosen Management
        Route::resource('dosen', DosenController::class);
        
        // Mata Kuliah Management
        Route::resource('mata-kuliah', MataKuliahController::class);
        
        // KRS Management
        Route::resource('krs', KrsController::class);
        
        // Nilai Management
        Route::resource('nilai', NilaiController::class);
        
        // Jadwal Management
        Route::resource('jadwal', JadwalController::class);
        Route::get('jadwal/export/pdf', [App\Http\Controllers\JadwalController::class, 'exportPDF'])->name('jadwal.export-pdf');
    });
    
    // Dosen Routes
    Route::middleware(['role:dosen'])->group(function () {
        Route::get('/dosen/dashboard', [DashboardController::class, 'dosenDashboard'])->name('dosen.dashboard');
        
        // KRS Management for Dosen
        Route::get('/dosen/krs', [KrsController::class, 'dosenIndex'])->name('dosen.krs.index');
        
        // Nilai Management for Dosen
        Route::get('/dosen/nilai', [NilaiController::class, 'dosenIndex'])->name('dosen.nilai.index');
        Route::get('/dosen/nilai/{nilai}/edit', [NilaiController::class, 'dosenEdit'])->name('dosen.nilai.edit');
        Route::put('/dosen/nilai/{nilai}', [NilaiController::class, 'dosenUpdate'])->name('dosen.nilai.update');
    });
    
    // Mahasiswa Routes
    Route::middleware(['role:mahasiswa'])->group(function () {
        Route::get('/mahasiswa/krs', [KrsController::class, 'mahasiswaIndex'])->name('mahasiswa.krs.index');
        Route::get('/mahasiswa/krs/create', [KrsController::class, 'mahasiswaCreate'])->name('mahasiswa.krs.create');
        Route::post('/mahasiswa/krs', [KrsController::class, 'mahasiswaStore'])->name('mahasiswa.krs.store');
        
        // Nilai Management for Mahasiswa
        Route::get('/mahasiswa/nilai', [NilaiController::class, 'mahasiswaIndex'])->name('mahasiswa.nilai.index');
    });
});

Route::middleware(['auth', 'role:dosen'])->group(function () {
    Route::get('dosen/jadwal', [App\Http\Controllers\JadwalController::class, 'jadwalDosen'])->name('dosen.jadwal');
});

Route::middleware(['auth', 'role:mahasiswa'])->group(function () {
    Route::get('mahasiswa/jadwal', [App\Http\Controllers\JadwalController::class, 'jadwalMahasiswa'])->name('mahasiswa.jadwal');
});
