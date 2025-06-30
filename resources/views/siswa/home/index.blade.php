@extends('siswa.layouts.master')

@section('title','Dashboard Siswa')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header">Selamat datang di halaman siswa.</div>

                <div class="card-body">
                    {{-- Tombol generate kode undangan --}}
                    <button id="genBtn" type="button" class="btn btn-green btn-sm">
                        Generate Kode Undangan
                    </button>
                    {{-- Tempat menampilkan kode --}}
                    <span id="codeBox" class="badge badge-success ml-2 d-none"></span>
                    {{-- ==== Tombol utama ==== --}}
                    <button id="toggleBtn"
                        data-has-sig="{{ $siswa->signature_data ? 1 : 0 }}"
                        class="btn btn-green btn-sm">
                        {{ $siswa->signature_data ? 'Tampilkan tanda tangan' : 'Daftarkan tanda tangan Anda' }}
                    </button>

                    {{-- ==== Preview jika sudah ada ==== --}}
                    @if($siswa->signature_data)
                    <img id="sigPreview"
                        src="{{ $siswa->signature_data }}"
                        class="border mt-3 d-none"
                        style="max-width:100%;height:auto;">
                    @endif

                    {{-- ==== Canvas form (hidden) ==== --}}
                    <form id="sigForm" class="mt-3 {{ $siswa->signature_data ? 'd-none' : '' }}">
                        @csrf
                        {{-- rekomendasi rotasi (muncul hanya di HP via CSS) --}}
                        <p id="rotateHint" class="text-muted small d-sm-none mb-2">
                            ⚠️&nbsp;Rekomendasi: miringkan smartphone agar kanvas lebih besar.
                        </p>

                        {{-- peringatan tidak bisa ganti --}}
                        <p class="text-danger small mb-1">
                            ⚠️&nbsp;Tanda tangan <strong>tidak bisa diganti</strong>. Pastikan sudah benar.
                        </p>
                        <canvas id="sigPad" class="border border-dark w-100"></canvas>

                        <input type="hidden" name="signature" id="signature">
                        <button type="button" id="clear" class="btn btn-secondary btn-sm mt-2">Clear</button>
                        <button type="button" id="save" class="btn btn-primary  btn-sm mt-2">Simpan</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(function() {
        $('#genBtn').on('click', function() {
            $.post("{{ route('siswa.generate-code') }}", {
                _token: "{{ csrf_token() }}"
            }, function(res) {
                $('#codeBox')
                    .text(`${res.code} (exp: ${res.expires})`)
                    .removeClass('d-none');
            }).fail(() => {
                alert('Gagal membuat kode, coba lagi atau hubungi admin.');
            });
        });
    });
</script>
@endpush

@push('scripts')
<script>
    $(function() {
        /* --- nilai awal --- */
        const hasSig = $('#toggleBtn').data('has-sig') == 1;
        const $preview = $('#sigPreview');
        const $form = $('#sigForm');
        const $toggle = $('#toggleBtn');

        // ① tombol toggle
        $toggle.on('click', () => {
            if (hasSig) {
                $preview.toggleClass('d-none');
                $toggle.text($preview.hasClass('d-none') ? 'Tampilkan tanda tangan' : 'Sembunyikan tanda tangan');
            } else {
                $form.toggleClass('d-none');
                $toggle.text($form.hasClass('d-none') ? 'Daftarkan tanda tangan Anda' : 'Tutup formulir');
                if (!$form.hasClass('d-none')) { // form baru saja ditampilkan
                    resize(); // hitung ulang dimensi canvas
                }
            }
        });


        // ② siapkan kanvas
        const canvas = document.getElementById('sigPad');
        if (!canvas) return; // safety

        const ctx = canvas.getContext('2d');
        const fillWhite = () => {
            ctx.fillStyle = '#fff';
            ctx.fillRect(0, 0, canvas.width, canvas.height);
        };
        const resize = () => {
            const r = window.devicePixelRatio || 1;
            canvas.width = canvas.clientWidth * r; // ⬅️ pakai clientWidth
            canvas.height = canvas.clientHeight * r; // ⬅️ pakai clientHeight
            ctx.resetTransform();
            ctx.scale(r, r);
            ctx.lineWidth = 2;
            fillWhite();
        };
        resize();
        window.addEventListener('resize', resize);

        /* gambar */
        let draw = false;
        const pos = e => {
            const rect = canvas.getBoundingClientRect();
            const t = e.touches ? e.touches[0] : e;
            return {
                x: t.clientX - rect.left,
                y: t.clientY - rect.top
            };
        };
        const start = e => {
            draw = true;
            const p = pos(e);
            ctx.beginPath();
            ctx.moveTo(p.x, p.y);
        };
        const move = e => {
            if (!draw) return;
            const p = pos(e);
            ctx.lineTo(p.x, p.y);
            ctx.stroke();
        };
        const stop = () => draw = false;

        canvas.addEventListener('mousedown', start);
        canvas.addEventListener('mousemove', move);
        canvas.addEventListener('mouseup', stop);
        canvas.addEventListener('mouseleave', stop);
        canvas.addEventListener('touchstart', e => {
            e.preventDefault();
            start(e)
        });
        canvas.addEventListener('touchmove', e => {
            e.preventDefault();
            move(e)
        });
        canvas.addEventListener('touchend', stop);

        $('#clear').on('click', () => {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            fillWhite();
        });

        function exportSignature() {
            // buat kanvas baru sebesar ukuran visual (CSS pixel)
            const out = document.createElement('canvas');
            out.width = canvas.clientWidth; // 300 px misalnya
            out.height = canvas.clientHeight; // 160 / 220 px

            // gambar ulang dari kanvas retina ➜ kanvas biasa
            out.getContext('2d').drawImage(canvas, 0, 0, out.width, out.height);

            return out.toDataURL('image/png');
        }
        // ③ simpan
        const isBlank = () => {
            const d = ctx.getImageData(0, 0, canvas.width, canvas.height).data;
            for (let i = 0; i < d.length; i += 4)
                if (d[i] !== 255 || d[i + 1] !== 255 || d[i + 2] !== 255) return false;
            return true;
        };
        $('#save').on('click', () => {
            if (isBlank()) return alert('Silakan tandatangani dahulu!');
            if (!confirm('Tanda tangan TIDAK BISA diganti. Yakin simpan?')) return;
            $('#signature').val(exportSignature());
            $.post("{{ route('siswa.signature.store') }}", $form.serialize())
                .done(() => location.reload())
                .fail(() => alert('Gagal menyimpan, coba lagi.'));
        });
    });
</script>
@endpush
@push('styles')
<style>
    /* desktop */
    #sigPad {
        width: 100%;
        height: 160px;
    }

    /* mobile ≤576 px */
    @media(max-width:576px) {
        #sigPad {
            height: 220px;
        }
    }

    /* sembunyikan hint saat ponsel landscape */
    @media (orientation:landscape) {
        #rotateHint {
            display: none;
        }
    }
</style>
@endpush