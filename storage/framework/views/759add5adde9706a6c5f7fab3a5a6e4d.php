<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $__env->yieldContent('title', 'Dashboard'); ?></title>

    <!-- Fonts & CSS -->
    <link href="<?php echo e(asset('sb-admin-2/vendor/fontawesome-free/css/all.min.css')); ?>" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="<?php echo e(asset('sb-admin-2/css/sb-admin-2.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('partialsGuru/style.css')); ?>" rel="stylesheet">
    <!-- DataTables -->
    <link href="<?php echo e(asset('sb-admin-2/vendor/datatables/dataTables.bootstrap4.min.css')); ?>" rel="stylesheet">
</head>

<?php echo $__env->yieldContent('style'); ?>
</head>

<body>
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <?php echo $__env->make('guru.partials.topbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <!-- Sidebar -->
            
            <!-- Sidebar Navigation -->
            <?php echo $__env->make('guru.partials.sidebarguru', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        </div>

        <button id="toggleSidebarBtn" class="toggle-btn">
            ☰
        </button>

        <!-- Main Content -->
        <div class="content-container">
            <!-- Content Will Be Yielded Here -->
            <?php echo $__env->yieldContent('content'); ?>
        </div>

        <!-- Bootstrap 5 JS (Optional for components like modals or dropdowns) -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

        <!-- jQuery (Needed for DataTables) -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script>
            const sidebar = document.getElementById('sidebar');
            const toggleSidebarBtn = document.getElementById('toggleSidebarBtn');

            // Toggle sidebar visibility when the button is clicked
            toggleSidebarBtn.addEventListener('click', () => {
                sidebar.style.transform = sidebar.style.transform === 'translateX(0%)' ? 'translateX(-100%)' :
                    'translateX(0%)';
                // toggleSidebarBtn.style.color = toggleSidebarBtn.style.color === 'black' ? 'white' : 'black';

                // Optionally, add a class to adjust main content position if needed
                const mainContent = document.querySelector('.content-container');
                mainContent.style.marginLeft = mainContent.style.marginLeft === '313px' ? '0' : '313px';
            });
        </script>

        <?php echo $__env->make('guru.partials.logout-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <?php echo $__env->yieldContent('script'); ?>

        <!-- Tambahkan sebelum closing tag </body> -->
        <!-- Logout Modal-->
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Yakin ingin keluar?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Pilih "Logout" di bawah jika anda siap untuk mengakhiri sesi anda saat ini.
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                        <form action="<?php echo e(route('logout')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-primary">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="<?php echo e(asset('sb-admin-2/vendor/jquery/jquery.min.js')); ?>"></script>
        <script src="<?php echo e(asset('sb-admin-2/vendor/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
        <!-- DataTables JS -->
        <script src="https://cdn.jsdelivr.net/npm/datatables.net@1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/datatables.net-bs5@1.11.5/js/dataTables.bootstrap5.min.js"></script>
</body>

</html>
<?php /**PATH /var/www/proyekAbsensiSmkWil/resources/views/guru/template/template.blade.php ENDPATH**/ ?>