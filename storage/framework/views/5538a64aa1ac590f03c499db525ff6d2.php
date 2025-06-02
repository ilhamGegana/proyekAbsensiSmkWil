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
    <!-- Select2 Dropdown -->
    <link href="<?php echo e(asset('select2/dist/css/select2.min.css')); ?>" rel="stylesheet" />
    <!-- Bootstrap 5 (CSS) -->
    <link href="<?php echo e(asset('bootstrap-5.3.6/css/bootstrap.min.css')); ?>" rel="stylesheet">
    <!-- DataTables -->
    <link href="<?php echo e(asset('sb-admin-2/vendor/datatables/dataTables.bootstrap4.min.css')); ?>" rel="stylesheet">
</head>

<body id="page-top">
    <div id="wrapper">
        <?php echo $__env->make('partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php echo $__env->make('partials.topbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                
                <?php if(session('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show mx-3 mt-3" role="alert">
                        <?php echo e(session('success')); ?>

                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if(session('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show mx-3 mt-3" role="alert">
                        <?php echo e(session('error')); ?>

                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                <div class="container-fluid">
                    <?php echo $__env->yieldContent('content'); ?>
                </div>
            </div>

            <?php echo $__env->make('partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="<?php echo e(asset('sb-admin-2/vendor/jquery/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('sb-admin-2/vendor/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
    <script src="<?php echo e(asset('sb-admin-2/vendor/jquery-easing/jquery.easing.min.js')); ?>"></script>
    <script src="<?php echo e(asset('sb-admin-2/js/sb-admin-2.min.js')); ?>"></script>
    <!-- Bootstrap 5 (JS) -->
    <script src="<?php echo e(asset('bootstrap-5.3.6/js/bootstrap.bundle.min.js')); ?>"></script>
    <!-- Select2 Dropdown -->
    <script src="<?php echo e(asset('select2/dist/js/select2.min.js')); ?>"></script>
    <!-- DataTables -->
    <script src="<?php echo e(asset('sb-admin-2/vendor/datatables/jquery.dataTables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('sb-admin-2/vendor/datatables/dataTables.bootstrap4.min.js')); ?>"></script>
    <script>
        $(document).on('shown.bs.offcanvas shown.bs.modal', function() {
            $('.select2').select2({
                width: '100%',
                placeholder: 'Pilih atau cari data',
                allowClear: true,
                minimumResultsForSearch: 0,
                dropdownParent: $('.offcanvas.show')
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>
    <?php echo $__env->make('partials.logout-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</body>

</html>
<?php /**PATH /var/www/html/resources/views/layouts/master.blade.php ENDPATH**/ ?>