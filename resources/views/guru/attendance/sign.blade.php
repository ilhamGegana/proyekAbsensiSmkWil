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

        function resize() {
            // keep crisp on resize
            const ratio = Math.max(window.devicePixelRatio || 1, 1);
            canvas.width = canvas.offsetWidth * ratio;
            canvas.height = canvas.offsetHeight * ratio;
            canvas.getContext("2d").scale(ratio, ratio);
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
        };

        document.getElementById('save').onclick = (e) => {
            const dataURL = canvas.toDataURL('image/png');
            document.getElementById('signature').value = dataURL;
        };
    </script>
@endsection
