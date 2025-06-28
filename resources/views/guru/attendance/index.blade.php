@extends('guru.template.template')
@section('title', 'Data Absensi')
@section('page-title', 'Data Absensi')
@section('content')
<div class="card shadow mb-4">
    {{-- ==== HEADER & FILTER JADWAL ==== --}}
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-green-custom">
            Absensi - {{ $today->format('d/m/Y') }}
        </h6>

        <form action="{{ route('guru.attendance') }}" id="formJadwal">
            <select name="jadwal" id="jadwal"
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
        </form>
    </div>

    {{-- ==== TABEL ==== --}}
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Siswa</th>
                        <th>NIS</th>
                        <th>Kelas</th>
                        <th>Status</th>
                        <th>Tanda Tangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $i => $student)
                    @php
                    $absen = $absensiMap[$student->id] ?? null;
                    $status = $absen->status_absen ?? 'Belum';
                    $css =
                    [
                    'hadir' => 'success',
                    'sakit' => 'info',
                    'izin' => 'warning',
                    'alpha' => 'danger',
                    'Belum' => 'secondary',
                    ][$status] ?? 'secondary';
                    @endphp
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $student->nama_siswa }}</td>
                        <td>{{ $student->nis }}</td>
                        <td>{{ $student->kelas->nama_kelas ?? '-' }}</td>

                        <td class="text-center">
                            <span class="btn btn-sm btn-{{ $css }}">{{ ucfirst($status) }}</span>
                        </td>

                        <td class="text-center">
                            @if ($absen && $absen->signature_ref)
                            <a href="{{ asset('signatures/' . $absen->signature_ref) }}" target="_blank"
                                class="btn btn-primary btn-sm">
                                <i class="fas fa-signature"></i> Lihat
                            </a>
                            @else
                            <a href="{{ route('guru.attendance.sign', [$student->id, 'jadwal' => $selectedScheduleId, 'date' => $today->toDateString()]) }}"
                                class="btn btn-success btn-sm">
                                <i class="fas fa-pen"></i> Tanda Tangan
                            </a>
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

@section('script')
<script>
    $(function() {
        $('#dataTable').DataTable({
            pageLength: 10,
            responsive: true
        });

        // ganti jadwal => submit form
        $('#jadwal').on('change', () => $('#formJadwal').submit());
    });
</script>
@endsection