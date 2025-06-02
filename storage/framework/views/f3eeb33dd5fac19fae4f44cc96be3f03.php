
<?php $__env->startSection('title', 'Tanda Tangan'); ?>

<?php $__env->startSection('content'); ?>
    <div class="card shadow mb-4">
        <div class="card-header font-weight-bold text-primary">
            Tanda Tangan – <?php echo e($siswa->nama_siswa); ?>

        </div>
        <div class="card-body">
            <canvas id="signature-pad" class="border border-dark" width="600" height="200"></canvas>

            <form id="formSign"
                action="<?php echo e(route('guru.attendance.storeSign', [$siswa->id, 'jadwal' => $jadwalId, 'date' => $date])); ?>"
                method="POST">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="signature" id="signature">
                <button type="button" id="clear" class="btn btn-secondary mt-3">Clear</button>
                <button type="submit" id="save" class="btn btn-primary mt-3">Save</button>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script>
        const canvas = document.getElementById('signature-pad');
        const ctx = canvas.getContext('2d');
        let drawing = false;

        // --- helper: isi putih seluruh kanvas  ---
        function fillWhite() {
            ctx.fillStyle = '#fff';
            ctx.fillRect(0, 0, canvas.width, canvas.height);
        }

        // --- resize agar tajam di Hi-DPI & tetap putih ---
        function resize() {
            const ratio = Math.max(window.devicePixelRatio || 1, 1);
            canvas.width = canvas.offsetWidth * ratio;
            canvas.height = canvas.offsetHeight * ratio;
            ctx.scale(ratio, ratio);
            fillWhite(); // <─ latar putih
        }
        window.onresize = resize;
        resize();

        canvas.addEventListener('mousedown', () => {
            drawing = true;
            ctx.beginPath();
        });
        canvas.addEventListener('mouseup', () => drawing = false);
        canvas.addEventListener('mousemove', draw);
        canvas.addEventListener('touchstart', (e) => {
            e.preventDefault();
            startTouch(e);
        });
        canvas.addEventListener('touchmove', (e) => {
            e.preventDefault();
            moveTouch(e);
        });

        function draw(e) {
            if (!drawing) return;
            ctx.lineWidth = 2;
            ctx.lineCap = 'round';
            ctx.strokeStyle = '#000';

            const rect = canvas.getBoundingClientRect();
            ctx.lineTo(e.clientX - rect.left, e.clientY - rect.top);
            ctx.stroke();
        }

        function startTouch(e) {
            drawing = true;
            const rect = canvas.getBoundingClientRect();
            ctx.beginPath();
            ctx.moveTo(e.touches[0].clientX - rect.left, e.touches[0].clientY - rect.top);
        }

        function moveTouch(e) {
            if (!drawing) return;
            const rect = canvas.getBoundingClientRect();
            ctx.lineTo(e.touches[0].clientX - rect.left, e.touches[0].clientY - rect.top);
            ctx.stroke();
        }

        document.getElementById('clear').onclick = () => {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            fillWhite(); // <─ kembalikan latar putih
        };

        // tombol Save → kirim dataURL
        document.getElementById('save').onclick = () => {
            // pastikan ada latar putih sebelum konversi
            // (opsional bila fillWhite selalu dipanggil)
            const dataURL = canvas.toDataURL('image/png');
            document.getElementById('signature').value = dataURL;
        };
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('guru.template.template', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/guru/attendance/sign.blade.php ENDPATH**/ ?>