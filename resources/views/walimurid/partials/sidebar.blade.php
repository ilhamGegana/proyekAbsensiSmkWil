<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('walimurid.walimurid.dashboard') }}">
        <div class="sidebar-brand-icon">
            <img src="{{ asset('images/logoWilangan.png') }}" alt="Logo SMK" style="height: 40px;">
        </div>
        <div class="sidebar-brand-text mx-3">SMK WILANGAN</div>
    </a>

    <hr class="sidebar-divider my-0">
  
    <!-- Dashboard -->
    <li class="nav-item {{ request()->routeIs('walimurid.walimurid.dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('walimurid.walimurid.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <!-- MASTER DATA -->
    <div class="sidebar-heading">Master Data</div>

    <li class="nav-item {{ request()->routeIs('walimurid.walimurid.history') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('walimurid.walimurid.history') }}">
            <i class="fas fa-user-graduate"></i>
            <span>Histori Siswa</span>
        </a>
    </li>

</ul>
