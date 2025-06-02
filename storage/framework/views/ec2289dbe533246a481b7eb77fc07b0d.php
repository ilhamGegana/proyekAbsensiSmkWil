<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo e(route('guru.home')); ?>">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-school"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SMK WILANGAN</div>
    </a>

    <hr class="sidebar-divider my-0">

    <li class="nav-item active">
        <a class="nav-link" href="<?php echo e(route('guru.home')); ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Home</span>
        </a>
    </li>

    <hr class="sidebar-divider">

   

    <li class="nav-item">
        <a class="nav-link" href="<?php echo e(route('guru.attendance')); ?>">
            <i class="fas fa-user-graduate"></i>
            <span>Attendance</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?php echo e(route('guru.history')); ?>">
            <i class="fas fa-chalkboard-teacher"></i>
            <span>History</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?php echo e(route('guru.students.index')); ?>">
            <i class="fas fa-users"></i>
            <span>Students</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-users-cog"></i>
            <span>Setting</span>
        </a>
    </li>
   <?php /**PATH /var/www/html/resources/views/guru/partials/sidebarguru.blade.php ENDPATH**/ ?>