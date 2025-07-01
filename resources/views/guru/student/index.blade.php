@extends('guru.template.template')

@section('title','Daftar Siswa & Status Absen')
@section('page-title','Daftar Siswa & Status Absen')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header font-weight-bold text-green-custom">
        Daftar Siswa - {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}
    </div>

    <div class="card-body">

        {{-- ①  ─── KALAU TIDAK ADA JADWAL ───────────────────────── --}}
        @if ($schedules->isEmpty())
        <div class="alert alert-info">
            Tidak ada jadwal aktif pada {{ \Carbon\Carbon::parse($date)->isoFormat('dddd') }}.
            Silakan pilih tanggal lain.
        </div>

        @else
        {{-- ②  ─── FILTER NORMAL (jadwal tersedia) ───────────────── --}}
        <form action="{{ route('guru.students.index') }}" id="formFilter" method="get" class="mb-4">
            <div class="row">
                {{-- ▼ JADWAL --}}
                <div class="col-md-4 mb-2">
                    <select name="jadwal"
                        id="jadwal"
                        class="form-control form-control-sm"
                        onchange="this.form.submit()">
                        @foreach ($schedules as $sch)
                        <option value="{{ $sch->id }}"
                            {{ $sch->id == $selectedScheduleId ? 'selected' : '' }}>
                            {{ $sch->kelas->nama_kelas }}
                            - {{ $sch->mapel->nama_mapel }}
                            - Jam ke-{{ $sch->jam_ke }}
                        </option>
                        @endforeach
                    </select>
                </div>

                {{-- ▼ CARI NAMA --}}
                <div class="col-md-3 mb-2">
                    <input type="text" name="name" id="name"
                        class="form-control form-control-sm"
                        placeholder="Cari nama…"
                        value="{{ request('name') }}">
                </div>
            </div>
        </form>

        {{-- ③  ─── TABEL SISWA ───────────────────────────────────── --}}
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>NIS</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $i => $student)
                    @php
                    $absen = $student->absensi->first();
                    $status = $absen->status_absen ?? 'Belum';
                    $color = [
                    'hadir'=>'success','sakit'=>'info','izin'=>'warning',
                    'alpha'=>'danger','Belum'=>'secondary'
                    ][$status] ?? 'secondary';
                    @endphp
                    <tr>
                        <td>{{ $i+1 }}</td>
                        <td>{{ $student->nis }}</td>
                        <td>{{ $student->nama_siswa }}</td>
                        <td>{{ $student->kelas->nama_kelas ?? '-' }}</td>
                        <td class="text-center">
                            <span class="btn btn-sm btn-{{ $color }}">{{ ucfirst($status) }}</span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('guru.students.edit', [
                                        $student->id,
                                        'jadwal' => $selectedScheduleId,
                                        'date'   => $date
                                    ]) }}" class="btn btn-sm btn-secondary">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif {{-- end if schedules->isEmpty --}}
    </div>
</div>
@endsection


@push('scripts') {{-- ganti section jadi push agar tidak bentrok --}}
<script>
    $(function() {
        $('#dataTable').DataTable({
            pageLength: 10,
            responsive: true
        });

        $('#jadwal,#date,#name').on('change', () => $('#formFilter').submit());
    });
</script>
@endpush