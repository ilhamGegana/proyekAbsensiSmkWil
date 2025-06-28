@extends('admin.layouts.master')

@section('title', 'Rekap Absensi')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Rekap Absensi</h1>

<div class="card mb-4">
    <div class="card-header">Filter Data</div>
    <div class="card-body">
        <form action="{{ route('rekap.index') }}" method="GET">
            <div class="row">
                <div class="col-md-4 mb-2">
                    <label for="tanggal_awal">Dari Tanggal</label>
                    <input type="date" name="tanggal_awal" id="tanggal_awal" class="form-control"
                        value="{{ request('tanggal_awal') }}">
                </div>
                <div class="col-md-4 mb-2">
                    <label for="tanggal_akhir">Sampai Tanggal</label>
                    <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control"
                        value="{{ request('tanggal_akhir') }}">
                </div>
                <div class="col-md-4 mb-2">
                    <label for="kelas">Kelas</label>
                    <select name="kelas" id="kelas" class="form-control">
                        <option value="">-- Semua Kelas --</option>
                        @foreach ($kelasList as $kelas)
                        <option value="{{ $kelas->id }}" {{ request('kelas') == $kelas->id ? 'selected' : '' }}>
                            {{ $kelas->nama_kelas }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-2">
                    <label for="siswa">Nama Siswa</label>
                    <select name="siswa" id="siswa" class="form-control select2">
                        <option value="">-- Semua Siswa --</option>
                        @php
                        $daftarNama = $data->pluck('siswa.nama_siswa')->unique();
                        @endphp
                        @foreach ($daftarNama as $nama)
                        <option value="{{ $nama }}" {{ request('siswa') == $nama ? 'selected' : '' }}>
                            {{ $nama }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-12 d-flex justify-content-start mt-2">
                    <button class="btn btn-primary me-2" type="submit">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                    <a href="{{ route('rekap.download.excel', request()->all()) }}" class="btn btn-success">
                        <i class="fas fa-file-excel"></i> Download Excel
                    </a>
                    <a href="{{ route('rekap.download.pdf', request()->all()) }}" class="btn btn-danger ms-2">
                        <i class="fas fa-file-pdf"></i> Download PDF
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

@if (count($data) > 0)
<div class="card">
    <div class="card-header">Hasil Rekap</div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Tanggal</th>
                        <th>Jam Pelajaran</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                    <tr>
                        <td>{{ $item->siswa->nama_siswa ?? '-' }}</td>
                        <td>{{ $item->siswa->kelas->nama_kelas ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tgl_waktu_absen)->format('d/m/Y') }}</td>
                        <td>{{ $item->jadwal->jam_ke ?? '-' }}</td>
                        <td>{{ ucfirst($item->status_absen) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif
@endsection

<script>
    $(document).ready(function() {
        $('#siswa').select2({
            placeholder: 'Pilih siswa',
            allowClear: true,
        });
    });
</script>