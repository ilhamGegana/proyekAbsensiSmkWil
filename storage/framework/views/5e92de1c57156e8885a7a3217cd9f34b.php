
<?php $__env->startSection('title', 'Daftar Siswa & Status Absen'); ?>

<?php $__env->startSection('content'); ?>
    <div class="card shadow mb-4">
        <div class="card-header font-weight-bold text-primary">Daftar Siswa –
            <?php echo e(\Carbon\Carbon::parse($date)->format('d/m/Y')); ?></div>

        <div class="card-body">
            
            <form action="<?php echo e(route('guru.students.index')); ?>" method="get" id="formFilter" class="mb-4">
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <input type="date" name="date" id="date" class="form-control form-control-sm"
                            value="<?php echo e($date); ?>">
                    </div>
                    <div class="col-md-3 mb-2">
                        <input type="text" name="name" id="name" class="form-control form-control-sm"
                            placeholder="Cari nama…" value="<?php echo e(request('name')); ?>">
                    </div>
                    <div class="col-md-3 mb-2">
                        <select name="class" id="class" class="form-control form-control-sm">
                            <option value="">Pilih Kelas</option>
                            <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kelas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($kelas->id); ?>" <?php echo e(request('class') == $kelas->id ? 'selected' : ''); ?>>
                                    <?php echo e($kelas->nama_kelas); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
            </form>

            
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>NIS</th>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $absen = $student->absensi->first();
                                $status = $absen->status_absen ?? 'Belum';
                                $color =
                                    [
                                        'hadir' => 'success',
                                        'sakit' => 'info',
                                        'izin' => 'warning',
                                        'alpha' => 'danger',
                                        'Belum' => 'secondary',
                                    ][$status] ?? 'secondary';
                            ?>
                            <tr>
                                <td><?php echo e($i + 1); ?></td>
                                <td><?php echo e($student->nis); ?></td>
                                <td><?php echo e($student->nama_siswa); ?></td>
                                <td><?php echo e($student->kelas->nama_kelas ?? '-'); ?></td>
                                <td class="text-center">
                                    <span class="btn btn-sm btn-<?php echo e($color); ?>"><?php echo e(ucfirst($status)); ?></span>
                                </td>
                                <td class="text-center">
                                    <a href="<?php echo e(route('guru.students.edit', [$student->id, 'date' => $date])); ?>"
                                        class="btn btn-sm btn-secondary">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script>
        $(function() {
            $('#dataTable').DataTable({
                pageLength: 10,
                responsive: true
            });
            $('#date,#name,#class').on('change', () => $('#formFilter').submit());
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('guru.template.template', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/guru/student/index.blade.php ENDPATH**/ ?>