@extends('siswa.layouts.master')

@section('title', 'Rekap Absensi')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Rekap Absensi</h6>
    </div>

    <div class="card-body">
        {{-- Filter --}}
        <form action="{{ route('siswa.history') }}" method="get" id="formFilter" class="mb-4">
            <div class="row">
                <div class="col-md-3 mb-2">
                    <label class="small font-weight-bold">Dari Tanggal</label>
                    <input type="date" name="from" class="form-control form-control-sm"
                        value="{{ request('from') }}">
                </div>

                <div class="col-md-3 mb-2">
                    <label class="small font-weight-bold">Sampai Tanggal</label>
                    <input type="date" name="to" class="form-control form-control-sm"
                        value="{{ request('to') }}">
                </div>

                <div class="col-md-3 mb-2">
                    <label class="small font-weight-bold">Minggu ke-</label>
                    <select name="week" class="form-control form-control-sm">
                        <option value="">-- Pilih Minggu --</option>
                        @for ($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}" {{ request('week') == $i ? 'selected' : '' }}>
                            Minggu ke-{{ $i }}
                            </option>
                            @endfor
                    </select>
                </div>
            </div>
        </form>

        {{-- Tabel --}}
        <div class="table-responsive">
            <table class="table table-bordered w-100" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Total Alpha</th>
                        <th>Total Sakit</th>
                        <th>Total Izin</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $siswa->nama_siswa }}</td>
                        <td>{{ $siswa->kelas->nama_kelas ?? '-' }}</td>
                        <td class="text-center"><span class="badge badge-danger">{{ $totalAlpha }}</span></td>
                        <td class="text-center"><span class="badge badge-info">{{ $totalSakit }}</span></td>
                        <td class="text-center"><span class="badge badge-warning">{{ $totalIzin }}</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(function() {
        // Auto submit saat filter diubah
        $('#formFilter input, #formFilter select').on('change', function() {
            $('#formFilter').submit();
        });
    });
</script>
@endpush