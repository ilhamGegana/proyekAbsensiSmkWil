{{-- @extends('guru/template/template')

@section('style')
  <style>
    #attendanceTable {
      font-size: 24px;
      font-weight: 400;
    }
  </style>
@endsection

@section('content')
  <div class="container-header mb-5">Attendance</div>

  <div class="container p-0">
    <!-- Example DataTable -->
    <div class="table-responsive">
      <table id="attendanceTable" class="table table-striped">
        <thead>
          <tr>
            <th>Name</th>
            <th>Student ID</th>
            <th>Class</th>
            <th>Status</th>
            <th>Signature</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($attendances as $attendance)
            <tr>
              <td>{{ $attendance->student->name }}</td>
              <td>{{ $attendance->student->student_id }}</td>
              <td>{{ $attendance->student->class }}</td>
              <td><button class="btn btn-{{ $attendance->status }}">{{ ucwords($attendance->status) }}</button></td>
              <td><button class="btn btn-signature">Signature</button></td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection

@section('script')
  <script>
    $(document).ready(function() {
      // Initialize DataTable
      $('#attendanceTable').DataTable();
    });
  </script>
@endsection --}}
@extends('guru.template.template')
@section('title', 'Data Absensi')

@section('content')
    <div class="card shadow mb-4">
        {{-- ==== HEADER & FILTER JADWAL ==== --}}
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                Absensi – {{ $today->format('d/m/Y') }}
            </h6>

            {{-- Dropdown jadwal --}}
            <form action="{{ route('guru.attendance') }}" id="formJadwal">
                <select name="jadwal" id="jadwal" class="form-control form-control-sm">
                    @foreach ($schedules as $sch)
                        <option value="{{ $sch->id }}" {{ $sch->id == $selectedScheduleId ? 'selected' : '' }}>
                            {{ $sch->kelas->nama_kelas }} – {{ $sch->mapel->nama_mapel }}
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
