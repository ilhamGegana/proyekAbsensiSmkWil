<?php $__env->startSection('title', 'Jadwal Pelajaran'); ?>

<?php $__env->startSection('content'); ?>
<div class="card shadow mb-4">
    <div class="card-header d-flex justify-content-between">
        <h6 class="m-0 font-weight-bold text-green-custom">Jadwal Pelajaran</h6>
        <button class="btn btn-primary btn-sm" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTambahJadwal">
            + Tambah Jadwal
        </button>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead class="text-center">
                    <tr>
                        <th>#</th>
                        <th>Hari</th>
                        <th>Jam-ke</th>
                        <th>Kelas</th>
                        <th>Mapel</th>
                        <th>Guru</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $jadwalPelajaran; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $j): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="<?php echo e($j->is_active ? '' : 'table-secondary'); ?>">
                        <td class="text-center"><?php echo e($i+1); ?></td>
                        <td><?php echo e($j->hari); ?></td>
                        <td class="text-center"><?php echo e($j->jam_ke); ?></td>
                        <td><?php echo e($j->kelas->nama_kelas ?? '-'); ?></td>
                        <td><?php echo e($j->mapel->nama_mapel ?? '-'); ?></td>
                        <td><?php echo e($j->guru->nama_guru ?? '-'); ?></td>
                        <td class="text-center">
                            <span class="badge <?php echo e($j->is_active?'bg-success':'bg-secondary'); ?>">
                                <?php echo e($j->is_active ? 'Aktif':'Non-aktif'); ?>

                            </span>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-warning"
                                data-bs-toggle="offcanvas"
                                data-bs-target="#offcanvasEditJadwal<?php echo e($j->id); ?>">Edit
                            </button>

                            <!-- tombol toggle aktif/non-aktif -->
                            <form action="<?php echo e(route('jadwalPelajaran.toggle',$j->id)); ?>" method="POST"
                                class="d-inline"
                                onsubmit="return confirm('Yakin ingin mengubah status jadwal?')">
                                <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                <?php if($j->is_active): ?>
                                <button class="btn btn-sm btn-danger">Nonaktifkan</button>
                                <?php else: ?>
                                <button class="btn btn-sm btn-success">Aktifkan</button>
                                <?php endif; ?>
                            </form>
                        </td>
                    </tr>

                    <!-- ============ OFFCANVAS EDIT ============ -->
                    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEditJadwal<?php echo e($j->id); ?>">
                        <div class="offcanvas-header">
                            <h5 class="offcanvas-title">Edit Jadwal</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                        </div>
                        <div class="offcanvas-body">
                            <form action="<?php echo e(route('jadwalPelajaran.update',$j->id)); ?>" method="POST">
                                <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>

                                <div class="mb-3">
                                    <label>Hari</label>
                                    <select name="hari" class="form-control" required>
                                        <?php $__currentLoopData = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hari): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($hari); ?>" <?php echo e($j->hari==$hari?'selected':''); ?>><?php echo e($hari); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label>Jam-ke</label>
                                    <input type="number" name="jam_ke" min="0" max="20"
                                        class="form-control" value="<?php echo e(old('jam_ke',$j->jam_ke)); ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label>Kelas</label>
                                    <select name="id_kelas" class="form-control select2" required>
                                        <option value="">-- Pilih Kelas --</option>
                                        <?php $__currentLoopData = $kelas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($k->id); ?>" <?php echo e($j->id_kelas==$k->id?'selected':''); ?>>
                                            <?php echo e($k->nama_kelas); ?>

                                        </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label>Mapel</label>
                                    <select name="id_mapel" class="form-control select2 mapel-select" required>
                                        <option value="">-- Pilih Mapel --</option>
                                        <?php $__currentLoopData = $mapel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($m->id); ?>"
                                            data-guru-id="<?php echo e($m->id_guru); ?>"
                                            data-guru-name="<?php echo e($m->guru?->nama_guru); ?>"
                                            <?php echo e($j->id_mapel == $m->id ? 'selected' : ''); ?>>
                                            <?php echo e($m->kode_mapel); ?> - <?php echo e($m->nama_mapel); ?>

                                        </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                
                                <div class="mb-3">
                                    <label>Guru Pengampu</label>
                                    <input type="text" class="form-control-plaintext guru-name"
                                        value="<?php echo e($j->guru->nama_guru ?? '-'); ?>" readonly>
                                    <input type="hidden" name="id_guru" value="<?php echo e($j->id_guru); ?>">
                                </div>

                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox"
                                        id="isActive<?php echo e($j->id); ?>" name="is_active"
                                        value="1" <?php echo e($j->is_active?'checked':''); ?>>
                                    <label class="form-check-label" for="isActive<?php echo e($j->id); ?>">Jadwal Aktif</label>
                                </div>

                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>
                    </div>
                    <!-- ============ END OFFCANVAS EDIT ============ -->

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ============ OFFCANVAS TAMBAH ============ -->
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
                    <?php $__currentLoopData = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hari): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($hari); ?>"><?php echo e($hari); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div class="mb-3">
                <label>Jam-ke</label>
                <input type="number" name="jam_ke" min="0" max="20" class="form-control" required>
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
                <select name="id_mapel" class="form-control select2 mapel-select" required>
                    <option value="">-- Pilih Mapel --</option>
                    <?php $__currentLoopData = $mapel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($m->id); ?>"
                        data-guru-id="<?php echo e($m->id_guru); ?>"
                        data-guru-name="<?php echo e($m->guru?->nama_guru); ?>">
                        <?php echo e($m->kode_mapel); ?> - <?php echo e($m->nama_mapel); ?>

                    </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            
            <div class="mb-3">
                <label>Guru Pengampu</label>
                <input type="text" class="form-control-plaintext guru-name" value="-" readonly>
                <input type="hidden" name="id_guru">
            </div>

            <button type="submit" class="btn btn-success">Simpan</button>
        </form>
    </div>
</div>
<!-- ============ END OFFCANVAS TAMBAH ============ -->
<?php $__env->stopSection(); ?>

<script>
    document.addEventListener('DOMContentLoaded', () => {

        /** Update nama & id guru ketika mapel berubah */
        function syncGuru(sel) {
            const frm = sel.closest('form');
            const txt = frm.querySelector('.guru-name');
            const hid = frm.querySelector('input[name="id_guru"]');

            const opt = sel.selectedOptions[0] || {};
            const gId = opt.dataset.guruId || '';
            const gNm = opt.dataset.guruName || '-';

            if (txt) txt.value = gNm;
            if (hid) hid.value = gId;
        }

        // jalankan untuk setiap select mapel di halaman
        document.querySelectorAll('select.mapel-select').forEach(sel => {
            syncGuru(sel); // set nilai awal (saat form dibuka)
            sel.addEventListener('change', () => syncGuru(sel));
        });
    });
</script>
<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/proyekAbsensiSmkWil/resources/views/admin/jadwalPelajaran/index.blade.php ENDPATH**/ ?>