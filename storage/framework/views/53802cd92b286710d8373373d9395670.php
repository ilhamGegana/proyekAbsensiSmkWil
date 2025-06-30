<?php $__env->startSection('title', 'Data Absensi'); ?>
<?php $__env->startSection('page-title', 'Data Absensi'); ?>
<?php $__env->startSection('content'); ?>
<div class="card shadow mb-4">
    
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-green-custom">
            Absensi - <?php echo e($today->format('d/m/Y')); ?>

        </h6>

        <form action="<?php echo e(route('guru.attendance')); ?>" id="formJadwal">
            <select name="jadwal" id="jadwal"
                class="form-control form-control-sm"
                onchange="this.form.submit()">
                <?php $__currentLoopData = $schedules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($sch->id); ?>"
                    <?php echo e($sch->id == $selectedScheduleId ? 'selected' : ''); ?>>
                    <?php echo e($sch->kelas->nama_kelas); ?>

                    - <?php echo e($sch->mapel->nama_mapel); ?>

                    - Jam ke-<?php echo e($sch->jam_ke); ?>

                </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </form>
    </div>

    
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Siswa</th>
                        <th>NIS</th>
                        <th>Kelas</th>
                        <th>Status</th>
                        <th>Tanda Tangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                    $absen = $absensiMap[$student->id] ?? null;
                    $status = $absen->status_absen ?? 'Belum';
                    $css =
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
                        <td><?php echo e($student->nama_siswa); ?></td>
                        <td><?php echo e($student->nis); ?></td>
                        <td><?php echo e($student->kelas->nama_kelas ?? '-'); ?></td>

                        <td class="text-center">
                            <span class="btn btn-sm btn-<?php echo e($css); ?>"><?php echo e(ucfirst($status)); ?></span>
                        </td>

                        <td class="text-center">
                            <?php if($absen && $absen->signature_ref): ?>
                            <div class="mb-2">
                                <img src="<?php echo e($absen->signature_ref); ?>"
                                    alt="Tanda Tangan"
                                    class="img-fluid border"
                                    style="max-width:200px; cursor: pointer;"
                                    data-bs-toggle="modal"
                                    data-bs-target="#sigModal">
                            </div>

                            <!-- Modal Bootstrap -->
                            <div class="modal fade" id="sigModal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Preview Tanda Tangan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <img src="<?php echo e($absen->signature_ref); ?>"
                                                alt="Tanda Tangan Besar"
                                                class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php else: ?>

                            <a href="<?php echo e(route('guru.attendance.sign', [$student->id, 'jadwal' => $selectedScheduleId, 'date' => $today->toDateString()])); ?>"
                                class="btn btn-success btn-sm">
                                <i class="fas fa-pen"></i> Tanda Tangan
                            </a>
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
            responsive: true
        });

        // ganti jadwal => submit form
        $('#jadwal').on('change', () => $('#formJadwal').submit());
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('guru.template.template', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/proyekAbsensiSmkWil/resources/views/guru/attendance/index.blade.php ENDPATH**/ ?>