

<?php $__env->startSection('title', 'Data Siswa'); ?>

<?php $__env->startSection('content'); ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-green-custom">Data Siswa</h6>
            <button class="btn btn-primary btn-sm" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTambahSiswa">+ Tambah Siswa</button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="text-center">
                        <tr>
                            <th>#</th>
                            <th>NIS</th>
                            <th>Nama</th>
                            <th>Jenis Kelamin</th>
                            <th>Kelas</th>
                            <th>No. Telp</th>
                            <th>Tgl Lahir</th>
                            <th>Alamat</th>
                            <th>Walimurid</th>
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
                                <td><?php echo e(\Carbon\Carbon::parse($s->tgl_lahir)->translatedFormat('d F Y') ?? '-'); ?></td>
                                <td><?php echo e($s->alamat_siswa ?? '-'); ?></td>
                                <td><?php echo e($s->walimurid->nama_walimurid ?? '-'); ?></td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="offcanvas"
                                        data-bs-target="#offcanvasEditSiswa<?php echo e($s->id); ?>">Edit</button>
                                    <form action="<?php echo e(route('siswa.destroy', $s->id)); ?>" method="POST" class="d-inline"
                                        onsubmit="return confirm('Yakin ingin menghapus siswa ini?')">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Offcanvas Edit Siswa -->
                            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEditSiswa<?php echo e($s->id); ?>">
                                <div class="offcanvas-header">
                                    <h5 class="offcanvas-title">Edit Siswa</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                                </div>
                                <div class="offcanvas-body">
                                    <form action="<?php echo e(route('siswa.update', $s->id)); ?>" method="POST">
                                        <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                                        <div class="mb-3">
                                            <label>NIS</label>
                                            <input type="text" name="nis" class="form-control"
                                                value="<?php echo e($s->nis); ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label>Nama Siswa</label>
                                            <input type="text" name="nama_siswa" class="form-control"
                                                value="<?php echo e($s->nama_siswa); ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label>Jenis Kelamin</label>
                                            <select name="jenis_kelamin" class="form-control" required>
                                                <option value="L" <?php echo e($s->jenis_kelamin == 'L' ? 'selected' : ''); ?>>
                                                    Laki-laki</option>
                                                <option value="P" <?php echo e($s->jenis_kelamin == 'P' ? 'selected' : ''); ?>>
                                                    Perempuan</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label>Kelas</label>
                                            <select name="id_kelas" class="select2" required>
                                                <option value="">-- Pilih atau cari kelas --</option>
                                                <?php $__currentLoopData = $kelas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($k->id); ?>"
                                                        <?php echo e($s->id_kelas == $k->id ? 'selected' : ''); ?>>
                                                        <?php echo e($k->nama_kelas); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label>No. Telp</label>
                                            <input type="text" name="no_telp_siswa" class="form-control"
                                                value="<?php echo e($s->no_telp_siswa); ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label>Tanggal Lahir</label>
                                            <input type="date" name="tgl_lahir" class="form-control"
                                                value="<?php echo e($s->tgl_lahir); ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label>Alamat</label>
                                            <textarea name="alamat_siswa" class="form-control" rows="2"><?php echo e($s->alamat_siswa); ?></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label>Walimurid</label>
                                            <select name="id_walimurid" class="select2">
                                                <option value="">-- Pilih atau cari walimurid --</option>
                                                <?php $__currentLoopData = $walimurid; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $w): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($w->id); ?>"
                                                        <?php echo e($s->id_walimurid == $w->id ? 'selected' : ''); ?>>
                                                        <?php echo e($w->nama_walimurid); ?>

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

    <!-- Offcanvas Tambah Siswa -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasTambahSiswa">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">Tambah Siswa</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <form action="<?php echo e(route('siswa.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="mb-3">
                    <label>NIS</label>
                    <input type="text" name="nis" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Nama Siswa</label>
                    <input type="text" name="nama_siswa" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-control" required>
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Kelas</label>
                    <select name="id_kelas" class="select2" required>
                        <option value="">-- Pilih atau cari kelas --</option>
                        <?php $__currentLoopData = $kelas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($k->id); ?>"><?php echo e($k->nama_kelas); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label>No. Telp</label>
                    <input type="text" name="no_telp_siswa" class="form-control">
                </div>
                <div class="mb-3">
                    <label>Tanggal Lahir</label>
                    <input type="date" name="tgl_lahir" class="form-control">
                </div>
                <div class="mb-3">
                    <label>Alamat</label>
                    <textarea name="alamat_siswa" class="form-control" rows="2"></textarea>
                </div>
                <div class="mb-3">
                    <label>Walimurid</label>
                    <select name="id_walimurid" class="select2">
                        <option value="">-- Pilih atau cari walimurid --</option>
                        <?php $__currentLoopData = $walimurid; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $w): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($w->id); ?>"><?php echo e($w->nama_walimurid); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-success">Simpan</button>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/siswa/index.blade.php ENDPATH**/ ?>