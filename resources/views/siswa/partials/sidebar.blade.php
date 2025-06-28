<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('siswa.dashboard') }}">
        <div class="sidebar-brand-icon">
            <img src="{{ asset('images/logoWilangan.png') }}" alt="Logo SMK" style="height: 40px;">
        </div>
        <div class="sidebar-brand-text mx-3">SMK WILANGAN</div>
    </a>

    <hr class="sidebar-divider my-0">

    <!-- Dashboard -->
    <li class="nav-item {{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('siswa.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <!-- MASTER DATA -->
    <div class="sidebar-heading">Master Data</div>

    <li class="nav-item {{ request()->routeIs('siswa.history*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('siswa.history') }}">
            <i class="fas fa-user-graduate"></i>
            <span>Histori Siswa</span>
        </a>
    </li>

</ul>