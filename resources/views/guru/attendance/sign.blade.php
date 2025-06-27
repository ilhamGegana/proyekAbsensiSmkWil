@extends('guru.template.template')
@section('title', 'Tanda Tangan')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header font-weight-bold text-primary">
        Tanda Tangan – {{ $siswa->nama_siswa }}
    </div>
    <div class="card-body">
        <canvas id="signature-pad" class="border border-dark" width="600" height="200"></canvas>

        <form id="formSign"
            action="{{ route('guru.attendance.storeSign', [$siswa->id, 'jadwal' => $jadwalId, 'date' => $date]) }}"
            method="POST">
            @csrf
            <input type="hidden" name="signature" id="signature">
            <button type="button" id="clear" class="btn btn-secondary mt-3">Clear</button>
            <button type="submit" id="save" class="btn btn-primary mt-3">Save</button>
        </form>
    </div>
</div>
@endsection

@section('script')
<script>
    const canvas = document.getElementById('signature-pad');
    const ctx = canvas.getContext('2d');
    let drawing = false;

    /* ────────── 1) Sesuaikan ukuran & garis ────────── */
    function resize() {
        const ratio = Math.max(window.devicePixelRatio || 1, 1);

        // simpan ukuran visual (CSS) sebelum diubah
        const w = canvas.offsetWidth;
        const h = canvas.offsetHeight;

        canvas.width = w * ratio; // resolusi internal → lebih tajam
        canvas.height = h * ratio;
        canvas.style.width = w + 'px'; // jaga ukuran visual
        canvas.style.height = h + 'px';

        ctx.resetTransform(); // pastikan transform bersih
        ctx.scale(ratio, ratio); // skala seluruh kanvas
        ctx.lineWidth = 2; // 2 CSS-pixel (≈ 2 × ratio actual)

        fillWhite();
    }
    window.addEventListener('resize', resize);
    resize();

    /* ────────── 2) Selalu isi latar putih ────────── */
    function fillWhite() {
        ctx.fillStyle = '#fff';
        ctx.fillRect(0, 0, canvas.width, canvas.height);
    }

    /* ────────── 3) Util posisi kursor/touch ────────── */
    function getPos(e) {
        const rect = canvas.getBoundingClientRect();
        if (e.touches) {
            return {
                x: e.touches[0].clientX - rect.left,
                y: e.touches[0].clientY - rect.top
            };
        }
        return {
            x: e.clientX - rect.left,
            y: e.clientY - rect.top
        };
    }

    /* ────────── 4) Event mouse ────────── */
    canvas.addEventListener('mousedown', e => {
        drawing = true;
        const {
            x,
            y
        } = getPos(e);
        ctx.beginPath();
        ctx.moveTo(x, y); // <─ posisi awal
    });
    canvas.addEventListener('mousemove', e => {
        if (!drawing) return;
        const {
            x,
            y
        } = getPos(e);
        ctx.lineTo(x, y);
        ctx.stroke();
    });
    canvas.addEventListener('mouseup', () => drawing = false);
    canvas.addEventListener('mouseleave', () => drawing = false);

    /* ────────── 5) Event touch ────────── */
    canvas.addEventListener('touchstart', e => {
        e.preventDefault();
        drawing = true;
        const {
            x,
            y
        } = getPos(e);
        ctx.beginPath();
        ctx.moveTo(x, y);
    });
    canvas.addEventListener('touchmove', e => {
        e.preventDefault();
        if (!drawing) return;
        const {
            x,
            y
        } = getPos(e);
        ctx.lineTo(x, y);
        ctx.stroke();
    });
    canvas.addEventListener('touchend', () => drawing = false);

    /* ────────── 6) Tombol clear & save ────────── */
    document.getElementById('clear').onclick = () => {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        fillWhite();
    };

    document.getElementById('save').onclick = () => {
        const dataURL = canvas.toDataURL('image/png');
        document.getElementById('signature').value = dataURL;
    };

    function isCanvasBlank(cv) {
        const ctx = cv.getContext('2d');
        const pixel = ctx.getImageData(0, 0, cv.width, cv.height).data;
        // cek cepat: jika ada satu pixel tak-putih → sudah diisi
        for (let i = 0; i < pixel.length; i += 4) {
            if (pixel[i] !== 255 || pixel[i + 1] !== 255 || pixel[i + 2] !== 255) {
                return false;
            }
        }
        return true;
    }

    document.getElementById('save').onclick = (e) => {
        if (isCanvasBlank(canvas)) {
            alert('Silakan gambar tanda tangan terlebih dahulu!');
            return;
        }
        const dataURL = canvas.toDataURL('image/png');
        document.getElementById('signature').value = dataURL;
        // baru submit form
        document.getElementById('formSign').submit();
    };
</script>
@endsection