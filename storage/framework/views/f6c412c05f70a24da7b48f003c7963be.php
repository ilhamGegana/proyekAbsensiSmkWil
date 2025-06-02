<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    <!-- Sidebar Toggle (untuk mobile) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3" style="color: #077a33;">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Sidebar Toggle (untuk desktop) -->
    <button id="sidebarToggle" class="btn btn-link d-none d-md-inline rounded-circle mr-3" style="color: #077a33;">
        <i class="fa fa-angle-double-left"></i>
    </button>

    <!-- Judul Halaman -->
    <h4 class="mb-0 text-gray-800"><?php echo $__env->yieldContent('page-title', 'Dashboard Admin'); ?></h4>

    <ul class="navbar-nav ml-auto">
        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo e(Auth::user()->username); ?></span>
                <img class="img-profile rounded-circle" src="<?php echo e(asset('sb-admin-2/img/undraw_profile.svg')); ?>">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="userDropdown">
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>
    </ul>
</nav>
<?php /**PATH /var/www/html/resources/views/admin/partials/topbar.blade.php ENDPATH**/ ?>