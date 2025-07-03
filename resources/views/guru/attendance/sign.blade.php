@extends('guru.template.template')
@section('title', 'Tanda Tangan')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header font-weight-bold text-primary">
        Tanda Tangan – {{ $siswa->nama_siswa }}
    </div>

    <div class="card-body">
        <p id="rotateHint" class="text-muted small d-sm-none mb-2">
            ⚠️ Rekomendasi: miringkan smartphone agar kanvas lebih besar.
        </p>

        <form id="formSign"
            action="{{ route('guru.attendance.storeSign', [$siswa->id, 'jadwal' => $jadwalId, 'date' => $date]) }}"
            method="POST">
            @csrf

            <canvas id="signature-pad" class="border border-dark w-100"></canvas>

            <input type="hidden" name="signature" id="signature">
            <button type="button" id="clear" class="btn btn-secondary mt-2">Clear</button>
            <button type="button" id="save" class="btn btn-primary mt-2">Simpan</button>
        </form>
    </div>
</div>
@endsection


@section('script')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const canvas = document.getElementById('signature-pad');
        const ctx = canvas.getContext('2d');
        let drawing = false;

        /* === resize retina === */
        const resize = () => {
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
            ctx.lineCap = ctx.lineJoin = 'round';
            ctx.strokeStyle = '#000';
            ctx.fillStyle = '#fff';
            ctx.fillRect(0, 0, canvas.width, canvas.height);
        };
        window.addEventListener('resize', resize);
        resize();

        /* === drawing handlers === */
        const pos = e => {
            const r = canvas.getBoundingClientRect();
            const t = e.touches ? e.touches[0] : e;
            return {
                x: t.clientX - r.left,
                y: t.clientY - r.top
            };
        };
        const start = e => {
            drawing = true;
            const p = pos(e);
            ctx.beginPath();
            ctx.moveTo(p.x, p.y);
        };
        const draw = e => {
            if (!drawing) return;
            const p = pos(e);
            ctx.lineTo(p.x, p.y);
            ctx.stroke();
        };
        const stop = () => drawing = false;

        canvas.addEventListener('mousedown', start);
        canvas.addEventListener('mousemove', draw);
        canvas.addEventListener('mouseup', stop);
        canvas.addEventListener('mouseout', stop);

        canvas.addEventListener('touchstart', e => {
            e.preventDefault();
            start(e);
        });
        canvas.addEventListener('touchmove', e => {
            e.preventDefault();
            draw(e);
        });
        canvas.addEventListener('touchend', stop);

        /* === helper === */
        const isBlank = () => {
            const buf = new Uint32Array(ctx.getImageData(0, 0, canvas.width, canvas.height).data.buffer);
            return !buf.some(c => c !== 0xFFFFFFFF);
        };

        /* === exportSignature: resize HANYA desktop (>=1024 px) === */
        const exportSignature = () => {
            if (window.matchMedia('(min-width: 1024px)').matches) {
                // Desktop → perkecil ke ukuran visual (CSS pixel)
                const out = document.createElement('canvas');
                out.width = canvas.clientWidth;
                out.height = canvas.clientHeight;
                out.getContext('2d').drawImage(canvas, 0, 0, out.width, out.height);
                return out.toDataURL('image/png');
            }
            // Mobile/tablet → kirim kanvas retina apa adanya
            return canvas.toDataURL('image/png');
        };

        /* === buttons === */
        document.getElementById('clear').addEventListener('click', () => {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            ctx.fillStyle = '#fff';
            ctx.fillRect(0, 0, canvas.width, canvas.height);
        });

        document.getElementById('save').addEventListener('click', () => {
            if (isBlank()) {
                alert('Silakan gambar tanda tangan terlebih dahulu!');
                return;
            }
            document.getElementById('signature').value = exportSignature();
            document.getElementById('formSign').submit();
        });
    });
</script>
@endsection


@push('styles')
<style>
    #signature-pad {
        width: 100%;
        height: 200px;
    }

    @media (max-width: 576px) {
        #signature-pad {
            height: 260px;
        }
    }

    @media (orientation: landscape) {
        #rotateHint {
            display: none;
        }
    }
</style>
@endpush