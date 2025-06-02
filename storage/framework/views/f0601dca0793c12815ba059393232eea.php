<?php $__env->startSection('title', 'Data Absensi'); ?>

<?php $__env->startSection('content'); ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-green-custom">Data Absensi</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="text-center">
                        <tr>
                            <th>#</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Hari</th>
                            <th>Mapel</th>
                            <th>Status</th>
                            <th>Waktu</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $absensi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="text-center"><?php echo e($i + 1); ?></td>
                                <td><?php echo e($a->siswa->nama_siswa ?? '-'); ?></td>
                                <td><?php echo e($a->jadwal->kelas->nama_kelas ?? '-'); ?></td>
                                <td><?php echo e($a->jadwal->hari ?? '-'); ?></td>
                                <td><?php echo e($a->jadwal->mapel->nama_mapel ?? '-'); ?></td>
                                <td><?php echo e(ucfirst($a->status_absen)); ?></td>
                                <td><?php echo e($a->tgl_waktu_absen); ?></td>
                                <td><?php echo e($a->keterangan ?? '-'); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/proyekAbsensiSmkWil/resources/views/admin/absensi/index.blade.php ENDPATH**/ ?>