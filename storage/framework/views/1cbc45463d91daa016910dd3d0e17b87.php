<?php $__env->startSection('title', 'Login'); ?>
<?php $__env->startSection('heading', 'Welcome Back!'); ?>

<?php $__env->startSection('form'); ?>
<form class="user" method="POST" action="<?php echo e(route('login')); ?>">
    <?php echo csrf_field(); ?>
    <div class="form-group">
        <input type="text" name="username" class="form-control form-control-user"
            placeholder="Username" required autofocus>
    </div>
    <div class="form-group">
        <input type="password" name="password" class="form-control form-control-user"
            placeholder="Password" required>
    </div>
    <div class="form-group">
        <div class="custom-control custom-checkbox small">
            <input type="checkbox" class="custom-control-input" id="remember" name="remember">
            <label class="custom-control-label" for="remember">Remember Me</label>
        </div>
    </div>
    <button type="submit" class="btn btn-green btn-user btn-block">Login</button>

    <?php if($errors->any()): ?>
    <div class="alert alert-danger mt-3"><?php echo e($errors->first()); ?></div>
    <?php endif; ?>
</form>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('extra-links'); ?>
<hr>
<div class="text-center">
    <a class="small text-green-custom" href="#">Forgot Password?</a>
</div>
<div class="text-center">
    <a class="small text-green-custom" href="<?php echo e(route('register')); ?>">Create an Account!</a>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.authMaster', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/proyekAbsensiSmkWil/resources/views/auth/login.blade.php ENDPATH**/ ?>