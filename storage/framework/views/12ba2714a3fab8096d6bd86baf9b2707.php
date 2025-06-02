

<?php $__env->startSection('title', 'Data Kelas'); ?>

<?php $__env->startSection('content'); ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-green-custom">Data Kelas</h6>
            <button class="btn btn-primary btn-sm" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTambah">+ Tambah
                Kelas</button>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="text-center">
                        <tr>
                            <th>#</th>
                            <th>Nama Kelas</th>
                            <th>Tingkat</th>
                            <th>Wali Kelas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $kelas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="text-center"><?php echo e($i + 1); ?></td>
                                <td><?php echo e($k->nama_kelas); ?></td>
                                <td><?php echo e($k->tingkat); ?></td>
                                <td><?php echo e($k->guru->nama_guru ?? '-'); ?></td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="offcanvas"
                                        data-bs-target="#offcanvasEdit<?php echo e($k->id); ?>">
                                        Edit
                                    </button>

                                    <form action="<?php echo e(route('kelas.destroy', $k->id)); ?>" method="POST" class="d-inline"
                                        onsubmit="return confirm('Yakin ingin menghapus?')">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Offcanvas Edit -->
                            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEdit<?php echo e($k->id); ?>"
                                aria-labelledby="offcanvasEditLabel<?php echo e($k->id); ?>">
                                <div class="offcanvas-header">
                                    <h5 class="offcanvas-title" id="offcanvasEditLabel<?php echo e($k->id); ?>">Edit Kelas</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                        aria-label="Close"></button>
                                </div>
                                <div class="offcanvas-body">
                                    <form action="<?php echo e(route('kelas.update', $k->id)); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PUT'); ?>
                                        <div class="mb-3">
                                            <label for="nama_kelas<?php echo e($k->id); ?>" class="form-label">Nama
                                                Kelas</label>
                                            <input type="text" name="nama_kelas" id="nama_kelas<?php echo e($k->id); ?>"
                                                value="<?php echo e($k->nama_kelas); ?>" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="tingkat<?php echo e($k->id); ?>" class="form-label">Tingkat</label>
                                            <input type="text" name="tingkat" id="tingkat<?php echo e($k->id); ?>"
                                                value="<?php echo e($k->tingkat); ?>" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="wali_kelas<?php echo e($k->id); ?>" class="form-label">Wali
                                                Kelas</label>
                                            <select name="id_guru" id="wali_kelas<?php echo e($k->id); ?>"
                                                class="form-control select2">
                                                <option value="">-- Pilih Guru --</option>
                                                <?php $__currentLoopData = $guru; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($g->id); ?>"
                                                        <?php echo e($k->id_guru == $g->id ? 'selected' : ''); ?>><?php echo e($g->nama_guru); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Offcanvas Tambah -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasTambah" aria-labelledby="offcanvasTambahLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasTambahLabel">Tambah Kelas</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form action="<?php echo e(route('kelas.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="mb-3">
                    <label for="nama_kelas" class="form-label">Nama Kelas</label>
                    <input type="text" name="nama_kelas" id="nama_kelas" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="tingkat" class="form-label">Tingkat</label>
                    <input type="text" name="tingkat" id="tingkat" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="id_guru" class="form-label">Wali Kelas</label>
                    <select name="id_guru" id="id_guru" class="form-control select2">
                        <option value="">-- Pilih Guru --</option>
                        <?php $__currentLoopData = $guru; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($g->id); ?>"><?php echo e($g->nama_guru); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-success">Simpan</button>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/kelas/index.blade.php ENDPATH**/ ?>