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

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

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
    Route::resource('mapel', MapelController::class);
    Route::resource('user', UserController::class);
    Route::resource('absensi', AbsensiController::class);
    Route::resource('jadwalPelajaran', JadwalPelajaranController::class);
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
