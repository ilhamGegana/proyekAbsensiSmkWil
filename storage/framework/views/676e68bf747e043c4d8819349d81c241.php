<?php $__env->startSection('title', 'Data User'); ?>

<?php $__env->startSection('content'); ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-green-custom">Data User</h6>
            <button class="btn btn-primary btn-sm" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTambah">+ Tambah
                User</button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%">
                    <thead class="text-center">
                        <tr>
                            <th>#</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Nama Terkait</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $user; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="text-center"><?php echo e($i + 1); ?></td>
                                <td><?php echo e($u->username); ?></td>
                                <td><?php echo e(ucfirst($u->role)); ?></td>
                                <td class="text-center">
                                    <span class="badge badge-<?php echo e($u->status_aktif ? 'success' : 'danger'); ?>">
                                        <?php echo e($u->status_aktif ? 'Aktif' : 'Nonaktif'); ?>

                                    </span>
                                </td>
                                <td>
                                    <?php if($u->siswa): ?>
                                        <?php echo e($u->siswa->nama_siswa); ?>

                                    <?php elseif($u->guru): ?>
                                        <?php echo e($u->guru->nama_guru); ?>

                                    <?php elseif($u->walimurid): ?>
                                        <?php echo e($u->walimurid->nama_walimurid); ?>

                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="offcanvas"
                                        data-bs-target="#offcanvasEdit<?php echo e($u->id); ?>">Edit</button>
                                    <form action="<?php echo e(route('user.destroy', $u->id)); ?>" method="POST" class="d-inline"
                                        onsubmit="return confirm('Yakin ingin menghapus?')">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Offcanvas Edit -->
                            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEdit<?php echo e($u->id); ?>">
                                <div class="offcanvas-header">
                                    <h5 class="offcanvas-title">Edit User</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                                </div>
                                <div class="offcanvas-body">
                                    <form action="<?php echo e(route('user.update', $u->id)); ?>" method="POST">
                                        <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                                        <div class="mb-3">
                                            <label>Username</label>
                                            <input type="text" name="username" value="<?php echo e($u->username); ?>"
                                                class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label>Password (Kosongkan jika tidak diubah)</label>
                                            <input type="password" name="password" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label>Role</label>
                                            <input type="text" class="form-control" value="<?php echo e(ucfirst($u->role)); ?>"
                                                readonly>
                                            <input type="hidden" name="role" value="<?php echo e($u->role); ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label>Status Aktif</label>
                                            <select name="status_aktif" class="form-control">
                                                <option value="1" <?php echo e($u->status_aktif ? 'selected' : ''); ?>>Aktif
                                                </option>
                                                <option value="0" <?php echo e(!$u->status_aktif ? 'selected' : ''); ?>>Nonaktif
                                                </option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label>Nama Terkait</label>
                                            <input type="text" class="form-control"
                                                value="<?php echo e($u->siswa->nama_siswa ?? ($u->guru->nama_guru ?? ($u->walimurid->nama_walimurid ?? '-'))); ?>"
                                                readonly>
                                            <input type="hidden" name="id_terkait"
                                                value="<?php echo e($u->id_siswa ?? ($u->id_guru ?? $u->id_walimurid)); ?>">
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
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasTambah">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">Tambah User</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <form action="<?php echo e(route('user.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="mb-3">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Role</label>
                    <select name="role" class="form-control" id="roleSelect" required>
                        <option value="">-- Pilih Role --</option>
                        <option value="admin">Admin</option>
                        <option value="guru">Guru</option>
                        <option value="siswa">Siswa</option>
                        <option value="walimurid">Walimurid</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Status Aktif</label>
                    <select name="status_aktif" class="form-control">
                        <option value="1">Aktif</option>
                        <option value="0">Nonaktif</option>
                    </select>
                </div>
                <div class="mb-3" id="divIdTerkait" style="display: none">
                    <label>Nama Terkait</label>
                    <select name="id_terkait" id="idTerkaitSelect" class="form-control select2">
                        <option value="">-- Pilih Nama --</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success">Simpan</button>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<script>
    function loadTerkaitSelect(role, targetSelect, selected = '') {
        if (role === 'guru' || role === 'siswa' || role === 'walimurid') {
            fetch(`<?php echo e(url('/user/terkait')); ?>/${role}`)
                .then(res => res.json())
                .then(data => {
                    let options = `<option value="">-- Pilih Nama --</option>`;
                    data.forEach(item => {
                        const isSelected = item.id == selected ? 'selected' : '';
                        options += `<option value="${item.id}" ${isSelected}>${item.nama}</option>`;
                    });
                    targetSelect.innerHTML = options;
                    $(targetSelect).select2({
                        dropdownParent: $(targetSelect).closest('.offcanvas')
                    });
                });
        } else {
            targetSelect.innerHTML = '';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Tambah User
        const roleSelect = document.getElementById('roleSelect');
        const idTerkaitSelect = document.getElementById('idTerkaitSelect');
        const divIdTerkait = document.getElementById('divIdTerkait');

        $(idTerkaitSelect).select2({
            dropdownParent: $('#offcanvasTambah')
        });

        roleSelect.addEventListener('change', function() {
            const role = roleSelect.value;
            if (role === 'guru' || role === 'siswa' || role === 'walimurid') {
                divIdTerkait.style.display = 'block';
                loadTerkaitSelect(role, idTerkaitSelect);
            } else {
                divIdTerkait.style.display = 'none';
                idTerkaitSelect.innerHTML = '';
            }
        });

        // Edit User (loop semua select-terkait)
        document.querySelectorAll('.select-terkait').forEach(select => {
            const role = select.dataset.role;
            const selected = select.dataset.selected;
            loadTerkaitSelect(role, select, selected);
        });
    });
</script>

<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/proyekAbsensiSmkWil/resources/views/admin/user/index.blade.php ENDPATH**/ ?>