

<?php $__env->startSection('title', 'Data Siswa'); ?>

<?php $__env->startSection('content'); ?>
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Data Siswa</h6>
        <a href="<?php echo e(route('siswa.create')); ?>" class="btn btn-primary btn-sm">+ Tambah Siswa</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable">
                <thead class="text-center">
                    <tr>
                        <th>#</th>
                        <th>NIS</th>
                        <th>Nama</th>
                        <th>Jenis Kelamin</th>
                        <th>Kelas</th>
                        <th>No. Telp</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $siswa; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="text-center"><?php echo e($i + 1); ?></td>
                        <td><?php echo e($s->nis); ?></td>
                        <td><?php echo e($s->nama_siswa); ?></td>
                        <td class="text-center"><?php echo e($s->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan'); ?></td>
                        <td><?php echo e($s->kelas->nama_kelas ?? '-'); ?></td>
                        <td><?php echo e($s->no_telp_siswa ?? '-'); ?></td>
                        <td class="text-center">
                            <a href="<?php echo e(route('siswa.edit', $s->id)); ?>" class="btn btn-sm btn-warning">Edit</a>
                            <form action="<?php echo e(route('siswa.destroy', $s->id)); ?>" method="POST" class="d-inline"
                                  onsubmit="return confirm('Yakin ingin menghapus siswa ini?')">
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
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/siswa/index.blade.php ENDPATH**/ ?>