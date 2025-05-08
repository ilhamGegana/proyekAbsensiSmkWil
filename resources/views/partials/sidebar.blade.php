<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-school"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SMK WILANGAN</div>
    </a>

    <hr class="sidebar-divider my-0">

    <li class="nav-item active">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">Master Data</div>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('siswa.index') }}">
            <i class="fas fa-user-graduate"></i>
            <span>Data Siswa</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('guru.index') }}">
            <i class="fas fa-chalkboard-teacher"></i>
            <span>Data Guru</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('walimurid.index') }}">
            <i class="fas fa-users"></i>
            <span>Data Walimurid</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('user.index') }}">
            <i class="fas fa-users-cog"></i>
            <span>Data User</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('kelas.index') }}">
            <i class="fas fa-door-open"></i>
            <span>Data Kelas</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('mapel.index') }}">
            <i class="fas fa-book"></i>
            <span>Data Mapel</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('jadwalPelajaran.index') }}">
            <i class="fas fa-calendar"></i>
            <span>Data Jadwal Pelajaran</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('absensi.index') }}">
            <i class="fas fa-clipboard-check"></i>
            <span>Data Kehadiran</span>
        </a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">
</ul>