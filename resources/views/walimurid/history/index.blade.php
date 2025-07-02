@extends('walimurid.layouts.master')

@section('title', 'Rekap Absensi Anak')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Rekap Absensi Anak</h6>
    </div>

    <div class="card-body">
        {{-- Filter --}}
        <form action="{{ route('walimurid.history') }}" method="get" id="formHistory" class="mb-4">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="small font-weight-bold d-block">Tanggal (dari - sampai)</label>
                    <div class="d-flex gap-1">
                        <input type="date" name="from" id="from"
                            class="form-control form-control-sm"
                            value="{{ request('from') }}">
                        <span class="align-self-center mx-2">-</span>
                        <input type="date" name="to" id="to"
                            class="form-control form-control-sm"
                            value="{{ request('to') }}">
                    </div>
                </div>

                <div class="col-md-3 mb-3">
                    <label class="small font-weight-bold">Minggu ke-</label>
                    <select name="week" id="week" class="form-control form-control-sm">
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
                    @forelse ($rekap as $data)
                    <tr>
                        <td>{{ $data['siswa']->nama_siswa }}</td>
                        <td>{{ $data['siswa']->kelas->nama_kelas ?? '-' }}</td>
                        <td class="text-center"><span class="badge badge-danger">{{ $data['totalAlpha'] }}</span></td>
                        <td class="text-center"><span class="badge badge-info">{{ $data['totalSakit'] }}</span></td>
                        <td class="text-center"><span class="badge badge-warning">{{ $data['totalIzin'] }}</span></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">Tidak ada data</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(function() {
        $('#from, #to, #week').on('change', function() {
            $('#formHistory').submit();
        });
    });
</script>
@endpush