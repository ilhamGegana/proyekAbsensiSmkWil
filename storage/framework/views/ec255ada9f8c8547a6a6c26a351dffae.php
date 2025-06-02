

<?php $__env->startSection('title', 'Data User'); ?>

<?php $__env->startSection('content'); ?>
<div class="card shadow mb-4">
    <div class="card-header d-flex justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Data User</h6>
        <a href="<?php echo e(route('user.create')); ?>" class="btn btn-primary btn-sm">+ Tambah User</a>
    </div>
    <div class="card-body">
        <table class="table table-bordered" id="dataTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Nama Terkait</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($i + 1); ?></td>
                    <td><?php echo e($u->username); ?></td>
                    <td><?php echo e(ucfirst($u->role)); ?></td>
                    <td>
                        <span class="badge badge-<?php echo e($u->status_aktif ? 'success' : 'danger'); ?>">
                            <?php echo e($u->status_aktif ? 'Aktif' : 'Nonaktif'); ?>

                        </span>
                    </td>
                    <td>
                        <?php if($u->siswa): ?>
                            <?php echo e($u->siswa->nama_siswa); ?>

                        <?php elseif($u->guru): ?>
                            <?php echo e($u->guru->nama_guru); ?>

                        <?php elseif($u->walimurid): ?>
                            <?php echo e($u->walimurid->nama_walimurid); ?>

                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?php echo e(route('user.edit', $u->id)); ?>" class="btn btn-sm btn-warning">Edit</a>
                        <form action="<?php echo e(route('user.destroy', $u->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/user/index.blade.php ENDPATH**/ ?>