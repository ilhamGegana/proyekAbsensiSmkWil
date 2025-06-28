@extends('siswa.layouts.master')

@section('title', 'History Absensi')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">History Absensi</h6>
        {{-- tombol ekspor bisa ditambahkan nanti --}}
    </div>

    <div class="card-body">
        {{-- Filter --}}
        <form action="{{ route('siswa.history') }}" method="get" id="formHistory" class="mb-4">
            <div class="row">
                <div class="col-md-5 mb-3">
                    <label class="small font-weight-bold">Dari Tanggal</label>
                    <input type="date" name="from" id="from"
                        class="form-control form-control-sm"
                        value="{{ request('from') }}">
                </div>

                <div class="col-md-5 mb-3">
                    <label class="small font-weight-bold">Sampai Tanggal</label>
                    <input type="date" name="to" id="to"
                        class="form-control form-control-sm"
                        value="{{ request('to') }}">
                </div>
            </div>
        </form>

        {{-- Tabel --}}
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
                    @foreach ($attendances as $i => $attendance)
                    @php
                    $color =
                    [
                    'hadir' => 'success',
                    'sakit' => 'info',
                    'izin' => 'warning',
                    'alpha' => 'danger',
                    ][$attendance->status_absen] ?? 'secondary';
                    @endphp

                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($attendance->tgl_waktu_absen)->format('d/m/Y') }}</td>
                        <td>{{ $attendance->siswa->nama_siswa }}</td>
                        <td>{{ $attendance->siswa->kelas->nama_kelas ?? '-' }}</td>
                        <td class="text-center">
                            <span class="btn btn-sm btn-{{ $color }}">
                                {{ ucfirst($attendance->status_absen) }}
                            </span>
                        </td>
                        <td class="text-center">
                            @if ($attendance->signature_ref)
                            <a href="{{ asset('storage/signatures/' . $attendance->signature_ref) }}"
                                target="_blank" class="btn btn-primary btn-sm">
                                <i class="fas fa-signature"></i> Lihat
                            </a>
                            @else
                            <span class="text-muted">—</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
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
                    sNext: ">",
                    sPrevious: "<"
                }
            }
        });

        // auto submit saat filter berubah
        $('#from,#to').on('change', () => $('#formHistory').submit());
    });
</script>
@endpush