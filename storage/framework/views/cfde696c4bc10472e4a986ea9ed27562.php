<?php $__env->startSection('title', 'Jadwal Pelajaran'); ?>

<?php $__env->startSection('content'); ?>
    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-green-custom">Jadwal Pelajaran</h6>
            <button class="btn btn-primary btn-sm" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTambahJadwal">+ Tambah
                Jadwal</button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="text-center">
                        <tr>
                            <th>#</th>
                            <th>Hari</th>
                            <th>Kelas</th>
                            <th>Mapel</th>
                            <th>Guru</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $jadwalPelajaran; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $j): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="text-center"><?php echo e($i + 1); ?></td>
                                <td><?php echo e($j->hari); ?></td>
                                <td><?php echo e($j->kelas->nama_kelas ?? '-'); ?></td>
                                <td><?php echo e($j->mapel->nama_mapel ?? '-'); ?></td>
                                <td><?php echo e($j->guru->nama_guru ?? '-'); ?></td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="offcanvas"
                                        data-bs-target="#offcanvasEditJadwal<?php echo e($j->id); ?>">Edit</button>
                                    <form action="<?php echo e(route('jadwalPelajaran.destroy', $j->id)); ?>" method="POST"
                                        class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Offcanvas Edit -->
                            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEditJadwal<?php echo e($j->id); ?>">
                                <div class="offcanvas-header">
                                    <h5 class="offcanvas-title">Edit Jadwal</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                                </div>
                                <div class="offcanvas-body">
                                    <form action="<?php echo e(route('jadwalPelajaran.update', $j->id)); ?>" method="POST">
                                        <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                                        <div class="mb-3">
                                            <label>Hari</label>
                                            <select name="hari" class="form-control" required>
                                                <?php $__currentLoopData = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hari): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($hari); ?>"
                                                        <?php echo e($j->hari == $hari ? 'selected' : ''); ?>><?php echo e($hari); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label>Kelas</label>
                                            <select name="id_kelas" class="form-control select2" required>
                                                <option value="">-- Pilih Kelas --</option>
                                                <?php $__currentLoopData = $kelas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($k->id); ?>"
                                                        <?php echo e($j->id_kelas == $k->id ? 'selected' : ''); ?>>
                                                        <?php echo e($k->nama_kelas); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label>Mapel</label>
                                            <select name="id_mapel" class="form-control select2" required>
                                                <option value="">-- Pilih Mapel --</option>
                                                <?php $__currentLoopData = $mapel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($m->id); ?>"
                                                        <?php echo e($j->id_mapel == $m->id ? 'selected' : ''); ?>>
                                                        <?php echo e($m->nama_mapel); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label>Guru</label>
                                            <select name="id_guru" class="form-control select2" required>
                                                <option value="">-- Pilih Guru --</option>
                                                <?php $__currentLoopData = $guru; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($g->id); ?>"
                                                        <?php echo e($j->id_guru == $g->id ? 'selected' : ''); ?>><?php echo e($g->nama_guru); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
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
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasTambahJadwal">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">Tambah Jadwal</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <form action="<?php echo e(route('jadwalPelajaran.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="mb-3">
                    <label>Hari</label>
                    <select name="hari" class="form-control" required>
                        <option value="">-- Pilih Hari --</option>
                        <?php $__currentLoopData = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hari): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($hari); ?>"><?php echo e($hari); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Kelas</label>
                    <select name="id_kelas" class="form-control select2" required>
                        <option value="">-- Pilih Kelas --</option>
                        <?php $__currentLoopData = $kelas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($k->id); ?>"><?php echo e($k->nama_kelas); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Mapel</label>
                    <select name="id_mapel" class="form-control select2" required>
                        <option value="">-- Pilih Mapel --</option>
                        <?php $__currentLoopData = $mapel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($m->id); ?>"><?php echo e($m->nama_mapel); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Guru</label>
                    <select name="id_guru" class="form-control select2" required>
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

<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/proyekAbsensiSmkWil/resources/views/admin/jadwalPelajaran/index.blade.php ENDPATH**/ ?>