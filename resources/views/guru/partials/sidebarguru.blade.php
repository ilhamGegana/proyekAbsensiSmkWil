{{-- resources/views/guru/partials/sidebarguru.blade.php --}}
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('guru.home') }}">
        <div class="sidebar-brand-icon">
            <img src="{{ asset('images/logoWilangan.png') }}" alt="Logo SMK" style="height:40px;">
        </div>
        <div class="sidebar-brand-text mx-3">SMK WILANGAN</div>
    </a>

    <hr class="sidebar-divider my-0">

    <!-- DASHBOARD -->
    <li class="nav-item {{ request()->routeIs('guru.home') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('guru.home') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <!-- ABSENSI -->
    <div class="sidebar-heading">Absensi</div>

    <li class="nav-item {{ request()->routeIs('guru.attendance') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('guru.attendance') }}">
            <i class="fas fa-user-check"></i>
            <span>Mulai Absensi</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('guru.students.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('guru.students.index') }}">
            <i class="fas fa-users"></i>
            <span>Absensi Manual</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <!-- DATA KELAS -->
    <div class="sidebar-heading">Kelas & Siswa</div>
    <li class="nav-item {{ request()->routeIs('guru.history') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('guru.history') }}">
            <i class="fas fa-history"></i>
            <span>Riwayat Absensi</span>
        </a>
    </li>
    <li class="nav-item {{ request()->routeIs('guru.rekap.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('guru.rekap.index') }}">
            <i class="fas fa-file-alt"></i>
            <span>Rekap Absensi</span>
        </a>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">Jadwal</div>
    <li class="nav-item {{ request()->routeIs('guru.jadwalPelajaran') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('guru.jadwalPelajaran') }}">
            <i class="fas fa-file-alt"></i>
            <span>Jadwal Pelajaran</span>
        </a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">
</ul>