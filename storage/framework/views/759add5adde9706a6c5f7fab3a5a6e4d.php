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
    <link href="<?php echo e(asset('partialsAdmin/style.css')); ?>" rel="stylesheet">
    <!-- <link href="<?php echo e(asset('partialsGuru/style.css')); ?>" rel="stylesheet"> -->
    <!-- DataTables -->
    <link href="<?php echo e(asset('sb-admin-2/vendor/datatables/dataTables.bootstrap4.min.css')); ?>" rel="stylesheet">

    <?php echo $__env->yieldContent('style'); ?>
</head>

<body id="page-top">
    <div id="wrapper">
        <?php echo $__env->make('guru.partials.sidebarguru', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php echo $__env->make('guru.partials.topbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                
                <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show mx-3 mt-3" role="alert">
                    <?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php endif; ?>

                <?php if(session('warning')): ?>
                <div class="alert alert-warning alert-dismissible fade show mx-3 mt-3" role="alert">
                    <?php echo e(session('warning')); ?>

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

            <?php echo $__env->make('guru.partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="<?php echo e(asset('sb-admin-2/vendor/jquery/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('sb-admin-2/vendor/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
    <script src="<?php echo e(asset('sb-admin-2/vendor/jquery-easing/jquery.easing.min.js')); ?>"></script>
    <script src="<?php echo e(asset('sb-admin-2/js/sb-admin-2.min.js')); ?>"></script>

    <!-- DataTables -->
    <script src="<?php echo e(asset('sb-admin-2/vendor/datatables/jquery.dataTables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('sb-admin-2/vendor/datatables/dataTables.bootstrap4.min.js')); ?>"></script>

    <?php echo $__env->make('guru.partials.logout-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <?php echo $__env->yieldContent('script'); ?>
</body>

</html><?php /**PATH /var/www/proyekAbsensiSmkWil/resources/views/guru/template/template.blade.php ENDPATH**/ ?>