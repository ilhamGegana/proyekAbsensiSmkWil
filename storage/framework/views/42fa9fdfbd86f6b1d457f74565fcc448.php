<?php $__env->startSection('title', 'Data Mapel'); ?>

<?php $__env->startSection('content'); ?>
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-green-custom">Data Mapel</h6>
        <button class="btn btn-primary btn-sm" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTambah">+ Tambah
            Mapel</button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead class="text-center">
                    <tr>
                        <th>#</th>
                        <th>Nama Mapel</th>
                        <th>Kode</th>
                        <th>Guru Pengampu</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $mapel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="text-center"><?php echo e($i + 1); ?></td>
                        <td class="text-center"><?php echo e($m->nama_mapel); ?></td>
                        <td class="text-center"><?php echo e($m->kode_mapel ?? '-'); ?></td>
                        <td class="text-center"><?php echo e($m->guru->nama_guru ?? '-'); ?></td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-warning" data-bs-toggle="offcanvas"
                                data-bs-target="#offcanvasEdit<?php echo e($m->id); ?>">
                                Edit
                            </button>
                            <form action="<?php echo e(route('mapel.destroy', $m->id)); ?>" method="POST" class="d-inline"
                                onsubmit="return confirm('Yakin ingin menghapus?')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    <!-- Offcanvas Edit -->
                    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEdit<?php echo e($m->id); ?>"
                        aria-labelledby="offcanvasEditLabel<?php echo e($m->id); ?>">
                        <div class="offcanvas-header">
                            <h5 class="offcanvas-title" id="offcanvasEditLabel<?php echo e($m->id); ?>">Edit Mapel</h5>
                            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body">
                            <form action="<?php echo e(route('mapel.update', $m->id)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PUT'); ?>
                                <div class="mb-3">
                                    <label for="nama_mapel<?php echo e($m->id); ?>" class="form-label">Nama Mapel</label>
                                    <input type="text" name="nama_mapel"
                                        id="nama_mapel<?php echo e($m->id); ?>"
                                        value="<?php echo e(old('nama_mapel', $m->nama_mapel)); ?>"
                                        class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label for="kode_mapel<?php echo e($m->id); ?>" class="form-label">Kode Mapel (opsional)</label>
                                    <input type="text" name="kode_mapel"
                                        id="kode_mapel<?php echo e($m->id); ?>"
                                        value="<?php echo e(old('kode_mapel', $m->kode_mapel)); ?>"
                                        class="form-control" maxlength="20">
                                </div>

                                <div class="mb-3">
                                    <label for="id_guru<?php echo e($m->id); ?>" class="form-label">Guru Pengampu</label>
                                    <select name="id_guru" id="id_guru<?php echo e($m->id); ?>" class="select2">
                                        <option value="">-- Pilih Guru --</option>
                                        <?php $__currentLoopData = $guru; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($g->id); ?>"
                                            <?php echo e($m->id_guru == $g->id ? 'selected' : ''); ?>>
                                            <?php echo e($g->nama_guru); ?>

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
        <h5 class="offcanvas-title" id="offcanvasTambahLabel">Tambah Mapel</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form action="<?php echo e(route('mapel.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="mb-3">
                <label for="nama_mapel" class="form-label">Nama Mapel</label>
                <input type="text" name="nama_mapel" id="nama_mapel"
                    class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="kode_mapel" class="form-label">Kode Mapel (opsional)</label>
                <input type="text" name="kode_mapel" id="kode_mapel"
                    class="form-control" maxlength="20">
            </div>

            <div class="mb-3">
                <label for="id_guru" class="form-label">Guru Pengampu</label>
                <select name="id_guru" id="id_guru" class="select2">
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
<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/proyekAbsensiSmkWil/resources/views/admin/mapel/index.blade.php ENDPATH**/ ?>