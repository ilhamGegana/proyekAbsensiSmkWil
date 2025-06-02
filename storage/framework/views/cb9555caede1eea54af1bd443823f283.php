<!-- Offcanvas Edit Guru -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEditGuru" aria-labelledby="offcanvasEditGuruLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasEditGuruLabel">Edit Guru</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form id="editGuruForm" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <input type="hidden" name="id" id="edit_id">

            <div class="mb-3">
                <label for="edit_nip" class="form-label">NIP</label>
                <input type="text" name="nip" id="edit_nip" class="form-control">
            </div>
            <div class="mb-3">
                <label for="edit_nama_guru" class="form-label">Nama Guru <span class="text-danger">*</span></label>
                <input type="text" name="nama_guru" id="edit_nama_guru" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="edit_email_guru" class="form-label">Email</label>
                <input type="email" name="email_guru" id="edit_email_guru" class="form-control">
            </div>
            <div class="mb-3">
                <label for="edit_telpon_guru" class="form-label">No Telp</label>
                <input type="text" name="telpon_guru" id="edit_telpon_guru" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
<?php /**PATH /var/www/html/resources/views/admin/guru/edit.blade.php ENDPATH**/ ?>