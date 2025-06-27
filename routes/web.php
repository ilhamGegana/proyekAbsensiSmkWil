<?php

use App\Http\Controllers\AbsensiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\JadwalPelajaranController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WalimuridController;
use App\Http\Controllers\Guru\HomeController;
use App\Http\Controllers\Guru\AttendanceController;
use App\Http\Controllers\Guru\HistoryController;
use \App\Http\Controllers\Guru\StudentController;
use App\Http\Controllers\Siswa\HalamanSiswaController;
use App\Http\Controllers\Walimurid\HalamanWaliMuridController;
use Illuminate\Support\Facades\Process;
use App\Http\Controllers\RekapAdminController;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register',  [AuthController::class, 'showRegisterForm'])
    ->name('register')
    ->middleware('guest', 'throttle:10,1');          // hanya tamu
Route::post('/register', [AuthController::class, 'register'])
    ->middleware('guest');

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard')->middleware('auth');

Route::prefix('admin')->group(function () {
    Route::resource('walimurid', WalimuridController::class);
    Route::resource('siswa', SiswaController::class);
    Route::resource('guru', GuruController::class);
    Route::resource('kelas', KelasController::class)->parameters([
        'kelas' => 'kelas'
    ]);
    Route::patch(
        '/jadwal/{jadwalPelajaran}/toggle',
        [JadwalPelajaranController::class, 'toggle']
    )->name('jadwalPelajaran.toggle');
    Route::resource('mapel', MapelController::class);
    Route::resource('user', UserController::class);
    Route::resource('absensi', AbsensiController::class);
    Route::resource('jadwalPelajaran', JadwalPelajaranController::class);
    Route::get('/rekap', [RekapAdminController::class, 'index'])->name('rekap.index');
    Route::get('/rekap/download', [RekapAdminController::class, 'download'])->name('rekap.download');
});

Route::get('/user/terkait/{role}', [UserController::class, 'getTerkait']);


//=========================================GURU=========================================

Route::middleware(['auth', 'role:guru'])
    ->prefix('guru')
    ->name('guru.')
    ->group(function () {
        Route::get('/home',  [HomeController::class, 'index'])
            ->name('home');

        Route::get('/attendance', [AttendanceController::class, 'index'])
            ->name('attendance');
        Route::get('/attendance/{siswa}/sign', [AttendanceController::class, 'signForm'])
            ->name('attendance.sign');
        Route::post('/attendance/{siswa}',       [AttendanceController::class, 'signStore'])
            ->name('attendance.storeSign');
        Route::get('/history', [HistoryController::class, 'index'])
            ->name('history');
        Route::get('/students', [StudentController::class, 'index'])
            ->name('students.index');

        Route::get('/students/{siswa}/edit', [StudentController::class, 'edit'])
            ->name('students.edit');

        Route::put('/students/{siswa}', [StudentController::class, 'update'])
            ->name('students.update');
    });

//=========================================SISWA=========================================
Route::middleware(['auth', 'role:siswa'])
    ->prefix('siswa')
    ->name('siswa.')
    ->group(function () {
        Route::get('/home',  [HalamanSiswaController::class, 'index'])
            ->name('siswa.dashboard');

        Route::get('/history', [HalamanSiswaController::class, 'history'])
            ->name('siswa.history');
        Route::post(
            '/generate-code',
            [HalamanSiswaController::class, 'generateCode']
        )
            ->middleware('throttle:5,1')
            ->name('generate-code');
    });


//=========================================WALIMURID=========================================
Route::middleware(['auth', 'role:walimurid'])
    ->prefix('walimurid')
    ->name('walimurid.')
    ->group(function () {
        Route::get('/home',  [HalamanWaliMuridController::class, 'index'])
            ->name('walimurid.dashboard');
        Route::get('/history', [HalamanWalimuridController::class, 'history'])
            ->name('walimurid.history');
    });


//=========================================TES TANDATANGAN=========================================
Route::get('/sig-test', function () {
    $ref = public_path('signature_data/example2.png');
    $new = public_path('signatures/test4.png');
    $out = Process::run(['python3', base_path('scripts/compare_sig.py'), $ref, $new])->output();
    return "Score = " . $out;
});
