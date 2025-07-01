@extends('guru.template.template')
@section('title', 'Tanda Tangan')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header font-weight-bold text-primary">
        Tanda Tangan - {{ $siswa->nama_siswa }}
    </div>
    <div class="card-body">
        {{-- Hint rotasi untuk mobile --}}
        <p id="rotateHint" class="text-muted small d-sm-none mb-2">
            ⚠️&nbsp;Rekomendasi: miringkan smartphone agar kanvas lebih besar.
        </p>

        {{-- Form dan Canvas --}}
        <form id="formSign"
            action="{{ route('guru.attendance.storeSign', [$siswa->id, 'jadwal' => $jadwalId, 'date' => $date]) }}"
            method="POST">
            @csrf
            <canvas id="signature-pad" class="border border-dark w-100"></canvas>

            <input type="hidden" name="signature" id="signature">
            <button type="button" id="clear" class="btn btn-secondary mt-2">Clear</button>
            <button type="submit" id="save" class="btn btn-primary mt-2">Simpan</button>
        </form>
    </div>
</div>

@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const canvas = document.getElementById('signature-pad');
        const ctx = canvas.getContext('2d');
        let drawing = false;
        let lastX = 0;
        let lastY = 0;

        // Fungsi resize canvas
        function resize() {
            const ratio = Math.max(window.devicePixelRatio || 1, 1);
            const w = canvas.offsetWidth;
            const h = canvas.offsetHeight;

            canvas.width = w * ratio;
            canvas.height = h * ratio;
            canvas.style.width = w + 'px';
            canvas.style.height = h + 'px';

            ctx.resetTransform();
            ctx.scale(ratio, ratio);
            ctx.lineWidth = 2;
            ctx.lineCap = 'round';
            ctx.lineJoin = 'round';
            ctx.strokeStyle = '#000';

            fillWhite();
        }

        function fillWhite() {
            ctx.fillStyle = '#fff';
            ctx.fillRect(0, 0, canvas.width, canvas.height);
        }

        function getPos(e) {
            const rect = canvas.getBoundingClientRect();
            return {
                x: (e.clientX || e.touches[0].clientX) - rect.left,
                y: (e.clientY || e.touches[0].clientY) - rect.top
            };
        }

        // Event listeners untuk mouse/touch
        function startDrawing(e) {
            drawing = true;
            const pos = getPos(e);
            lastX = pos.x;
            lastY = pos.y;
            ctx.beginPath();
            ctx.moveTo(lastX, lastY);
        }

        function draw(e) {
            if (!drawing) return;
            const pos = getPos(e);

            ctx.lineTo(pos.x, pos.y);
            ctx.stroke();

            // Simpan posisi terakhir
            lastX = pos.x;
            lastY = pos.y;
        }

        function stopDrawing() {
            drawing = false;
        }

        // Hitung kompleksitas tanda tangan
        function calculateComplexity() {
            const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
            const pixels = imageData.data;
            let signaturePixels = 0;

            for (let i = 0; i < pixels.length; i += 4) {
                if (pixels[i] !== 255 || pixels[i + 1] !== 255 || pixels[i + 2] !== 255) {
                    signaturePixels++;
                }
            }

            // Hitung perubahan arah untuk mengukur kompleksitas
            return signaturePixels;
        }

        // Cek jika canvas kosong
        function isCanvasBlank() {
            const pixelBuffer = new Uint32Array(
                ctx.getImageData(0, 0, canvas.width, canvas.height).data.buffer
            );
            return !pixelBuffer.some(color => color !== 0xFFFFFFFF);
        }

        // Event listeners
        canvas.addEventListener('mousedown', startDrawing);
        canvas.addEventListener('mousemove', draw);
        canvas.addEventListener('mouseup', stopDrawing);
        canvas.addEventListener('mouseout', stopDrawing);

        canvas.addEventListener('touchstart', function(e) {
            e.preventDefault();
            startDrawing(e.touches[0]);
        });

        canvas.addEventListener('touchmove', function(e) {
            e.preventDefault();
            draw(e.touches[0]);
        });

        canvas.addEventListener('touchend', stopDrawing);

        // Tombol clear
        document.getElementById('clear').addEventListener('click', function() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            fillWhite();
        });

        // Tombol save
        document.getElementById('save').addEventListener('click', function() {
            const MIN_COMPLEXITY = 800; // Sesuaikan nilai ini

            if (isCanvasBlank()) {
                alert('Silakan gambar tanda tangan terlebih dahulu!');
                return;
            }

            const complexity = calculateComplexity();
            if (complexity < MIN_COMPLEXITY) {
                alert('Tanda tangan terlalu sederhana. Harap gambar tanda tangan yang lebih detail.');
                return;
            }

            const dataURL = canvas.toDataURL('image/png');
            document.getElementById('signature').value = dataURL;
            document.getElementById('formSign').submit();
        });

        // Inisialisasi
        window.addEventListener('resize', resize);
        resize();
    });
</script>
@endsection
@push('styles')
<style>
    /* Default height untuk desktop */
    #signature-pad {
        width: 100%;
        height: 200px;
    }

    /* Mobile view: tinggi diperbesar agar nyaman ditulis */
    @media (max-width: 576px) {
        #signature-pad {
            height: 260px;
        }
    }

    /* Hint rotasi hanya muncul di portrait */
    @media (orientation: landscape) {
        #rotateHint {
            display: none;
        }
    }
</style>
@endpush
