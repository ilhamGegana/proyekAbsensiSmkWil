<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
        <div class="sidebar-brand-icon">
            <img src="{{ asset('images/logoWilangan.png') }}" alt="Logo SMK" style="height: 40px;">
        </div>
        <div class="sidebar-brand-text mx-3">SMK WILANGAN</div>
    </a>

    <hr class="sidebar-divider my-0">

    <!-- Dashboard -->
    <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <!-- MASTER DATA -->
    <div class="sidebar-heading">Master Data</div>

    <li class="nav-item {{ request()->routeIs('siswa.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('siswa.index') }}">
            <i class="fas fa-user-graduate"></i>
            <span>Data Siswa</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('guru.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('guru.index') }}">
            <i class="fas fa-chalkboard-teacher"></i>
            <span>Data Guru</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('walimurid.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('walimurid.index') }}">
            <i class="fas fa-users"></i>
            <span>Data Walimurid</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('kelas.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('kelas.index') }}">
            <i class="fas fa-door-open"></i>
            <span>Data Kelas</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('mapel.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('mapel.index') }}">
            <i class="fas fa-book"></i>
            <span>Data Mapel</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('user.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('user.index') }}">
            <i class="fas fa-users-cog"></i>
            <span>Data User</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <!-- TRANSAKSI -->
    <div class="sidebar-heading">Data Transaksi</div>

    <li class="nav-item {{ request()->routeIs('jadwalPelajaran.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('jadwalPelajaran.index') }}">
            <i class="fas fa-calendar"></i>
            <span>Jadwal Pelajaran</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('absensi.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('absensi.index') }}">
            <i class="fas fa-clipboard-check"></i>
            <span>Absensi</span>
        </a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">
</ul>
