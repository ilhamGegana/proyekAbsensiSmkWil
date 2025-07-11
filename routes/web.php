<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Process;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\WalimuridController;
use App\Http\Controllers\JadwalPelajaranController;
use App\Http\Controllers\RekapAdminController;
use App\Http\Controllers\SignatureSettingController;

use App\Http\Controllers\Guru\HomeController;
use App\Http\Controllers\Guru\HistoryController;
use App\Http\Controllers\Guru\StudentController;
use App\Http\Controllers\Guru\AttendanceController;
use App\Http\Controllers\Guru\RekapGuruController;

use App\Http\Controllers\Siswa\HalamanSiswaController;
use App\Http\Controllers\Walimurid\HalamanWaliMuridController;

// Redirect root to login
Route::redirect('/', '/login');

// Auth routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register')->middleware('throttle:10,1');
    Route::post('/register', [AuthController::class, 'register']);
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin area
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::view('/dashboard', 'admin.dashboard')->name('admin.dashboard');

    // Manual route untuk Kelas
    Route::get('kelas', [KelasController::class, 'index'])->name('kelas.index');
    Route::get('kelas/create', [KelasController::class, 'create'])->name('kelas.create');
    Route::post('kelas', [KelasController::class, 'store'])->name('kelas.store');
    Route::get('kelas/{kelas}', [KelasController::class, 'show'])->name('kelas.show');
    Route::get('kelas/{kelas}/edit', [KelasController::class, 'edit'])->name('kelas.edit');
    Route::put('kelas/{kelas}', [KelasController::class, 'update'])->name('kelas.update');
    Route::delete('kelas/{kelas}', [KelasController::class, 'destroy'])->name('kelas.destroy');

    // Resource lainnya tetap
    Route::resources([
        'walimurid' => WalimuridController::class,
        'siswa'     => SiswaController::class,
        'guru'      => GuruController::class,
        'mapel'     => MapelController::class,
        'user'      => UserController::class,
        'absensi'   => AbsensiController::class,
        'jadwalPelajaran' => JadwalPelajaranController::class,
    ]);

    Route::get('/signature-setting', [SignatureSettingController::class, 'edit'])->name('admin.signature.edit');
    Route::post('/signature-setting', [SignatureSettingController::class, 'update'])->name('admin.signature.update');

    Route::patch('/jadwal/{jadwalPelajaran}/toggle', [JadwalPelajaranController::class, 'toggle'])
        ->name('jadwalPelajaran.toggle');

    Route::prefix('rekap')->name('rekap.')->group(function () {
        Route::get('/', [RekapAdminController::class, 'index'])->name('index');
        Route::get('/download-excel', [RekapAdminController::class, 'downloadExcel'])->name('download.excel');
        Route::get('/download-pdf', [RekapAdminController::class, 'downloadPdf'])->name('download.pdf');
    });
});


// User terkait data
Route::get('/user/terkait/{role}', [UserController::class, 'getTerkait']);

// Guru area
Route::prefix('guru')->middleware(['auth', 'role:guru'])->name('guru.')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance');
    Route::get('/attendance/{siswa}/sign', [AttendanceController::class, 'signForm'])->name('attendance.sign');
    Route::post('/attendance/{siswa}', [AttendanceController::class, 'signStore'])->name('attendance.storeSign');
    Route::get('/history', [HistoryController::class, 'index'])->name('history');

    Route::prefix('students')->name('students.')->group(function () {
        Route::get('/', [StudentController::class, 'index'])->name('index');
        Route::get('{siswa}/edit', [StudentController::class, 'edit'])->name('edit');
        Route::put('{siswa}', [StudentController::class, 'update'])->name('update');
    });

    Route::prefix('rekap')->name('rekap.')->group(function () {
        Route::get('/', [RekapGuruController::class, 'index'])->name('index');
        Route::get('/download-excel', [RekapGuruController::class, 'downloadExcel'])->name('download.excel');
        Route::get('/download-pdf', [RekapGuruController::class, 'downloadPdf'])->name('download.pdf');
    });
});

// Siswa area
Route::prefix('siswa')->middleware(['auth', 'role:siswa'])->name('siswa.')->group(function () {
    Route::get('/home', [HalamanSiswaController::class, 'index'])->name('dashboard');
    Route::get('/history', [HalamanSiswaController::class, 'history'])->name('history');
    Route::post('/generate-code', [HalamanSiswaController::class, 'generateCode'])
        ->middleware('throttle:5,1')
        ->name('generate-code');
    Route::post('/signature', [HalamanSiswaController::class, 'storeSignature'])->name('signature.store');
});

// Walimurid area
Route::prefix('walimurid')->middleware(['auth', 'role:walimurid'])->name('walimurid.')->group(function () {
    Route::get('/home', [HalamanWaliMuridController::class, 'index'])->name('dashboard');
    Route::get('/history', [HalamanWaliMuridController::class, 'history'])->name('history');
});

Route::get('/jadwal-pelajaran/download-pdf', [JadwalPelajaranController::class, 'downloadPdf'])->name('jadwal-pelajaran.download');

Route::get('/guru/jadwalPelajaran', [\App\Http\Controllers\Guru\JadwalPelajaranguruController::class, 'index'])->name('guru.jadwalPelajaran');