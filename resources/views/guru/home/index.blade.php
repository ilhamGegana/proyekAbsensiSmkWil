{{-- resources/views/guru/home.blade.php --}}
@extends('guru.template.template')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Guru')
@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    <a href="{{ route('guru.attendance') }}" class="d-none d-sm-inline-block btn btn-green shadow-sm ">
        <i class="fas fa-clipboard-list fa-sm text-white-50 mr-2"></i>Mulai Absensi
    </a>
</div>

<!-- Content Row -->
<div class="row">
    {{-- Hadir --}}
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Hadir</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $presentCount }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-check fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Sakit --}}
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Sakit</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $sickCount }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-procedures fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Izin --}}
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Izin</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $permissionCount }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-envelope fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tidak Hadir / Alpha --}}
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Tidak Hadir</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $absentCount }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-times fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
