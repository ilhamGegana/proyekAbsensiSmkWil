




<?php $__env->startSection('title', 'History Absensi'); ?>

<?php $__env->startSection('content'); ?>
    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">History Absensi</h6>
            
        </div>

        <div class="card-body">
            
            <form action="<?php echo e(route('guru.history')); ?>" method="get" id="formHistory" class="mb-4">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="small font-weight-bold">Tanggal</label>
                        <input type="date" name="date" id="date" class="form-control form-control-sm"
                            value="<?php echo e(request('date')); ?>">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="small font-weight-bold">Nama Siswa</label>
                        <input type="text" name="name" id="name" class="form-control form-control-sm"
                            placeholder="Cari nama..." value="<?php echo e(request('name')); ?>">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="small font-weight-bold">Kelas</label>
                        <select name="class" id="class" class="form-control form-control-sm">
                            <option value="">Pilih Kelas</option>
                            <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($class->id); ?>" <?php echo e(request('class') == $class->id ? 'selected' : ''); ?>>
                                    <?php echo e($class->nama_kelas); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
            </form>

            
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tanggal</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Status</th>
                            <th>Tanda Tangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $attendances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $attendance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $color =
                                    [
                                        'hadir' => 'success',
                                        'sakit' => 'info',
                                        'izin' => 'warning',
                                        'alpha' => 'danger',
                                    ][$attendance->status_absen] ?? 'secondary';
                            ?>

                            <tr>
                                <td><?php echo e($i + 1); ?></td>
                                <td><?php echo e(\Carbon\Carbon::parse($attendance->tgl_waktu_absen)->format('d/m/Y')); ?></td>
                                <td><?php echo e($attendance->siswa->nama_siswa); ?></td>
                                <td><?php echo e($attendance->siswa->kelas->nama_kelas ?? '-'); ?></td>
                                <td class="text-center">
                                    <span class="btn btn-sm btn-<?php echo e($color); ?>">
                                        <?php echo e(ucfirst($attendance->status_absen)); ?>

                                    </span>
                                </td>
                                <td class="text-center">
                                    <?php if($attendance->signature_ref): ?>
                                        <a href="<?php echo e(asset('storage/signatures/' . $attendance->signature_ref)); ?>"
                                            target="_blank" class="btn btn-primary btn-sm">
                                            <i class="fas fa-signature"></i> Lihat
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted">—</span>
                                    <?php endif; ?>
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
                ordering: true,
                responsive: true,
                language: {
                    sEmptyTable: "Tidak ada data",
                    sInfo: "Menampilkan _START_-_END_ dari _TOTAL_ entri",
                    sInfoEmpty: "Menampilkan 0-0 dari 0 entri",
                    sInfoFiltered: "(disaring dari _MAX_ entri)",
                    sLengthMenu: "Tampilkan _MENU_ entri",
                    sSearch: "Cari:",
                    oPaginate: {
                        sFirst: "Pertama",
                        sLast: "Terakhir",
                        sNext: "›",
                        sPrevious: "‹"
                    }
                }
            });

            // auto submit saat filter berubah
            $('#date, #name, #class').on('change', () => $('#formHistory').submit());
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('guru.template.template', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/guru/history/index.blade.php ENDPATH**/ ?>