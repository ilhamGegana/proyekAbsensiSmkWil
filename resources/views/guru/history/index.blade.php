{{-- @extends('guru/template/template')

@section('style')
  <style>
    #attendanceTable {
      font-size: 24px;
      font-weight: 400;
    }

    .label-history {
      font-size: 24px;
      font-weight: 400;
    }
  </style>
@endsection

@section('content')
  <div class="container-header mb-5">History</div>

  <div class="container p-0">
    <form action="{{ route('history') }}" method="get" id="formHistory">
      <div class="row p-3 mb-3">
        <div class="col-4">
          <label for="date" class="label-history">Date</label>
          <input type="date" name="date" id="date" class="form-control"
            value="{{ request()->input('date', '') }}">
        </div>
        <div class="col-4">
          <label for="name" class="label-history">Name</label>
          <input type="text" name="name" id="name" class="form-control"
            value="{{ request()->input('name', '') }}">
        </div>
        <div class="col-4">
          <label for="class" class="label-history">Class</label>
          <select name="class" id="class" class="form-control">
            <option value="">Select Class</option>
            @foreach ($classes as $class)
              <option value="{{ $class->class }}" {{ request()->input('class') == $class->class ? 'selected' : '' }}>
                {{ $class->class }}
              </option>
            @endforeach
          </select>
        </div>
      </div>
    </form>
    <div class="table-responsive">
      <table id="attendanceTable" class="table table-striped">
        <thead>
          <tr>
            <th>Date</th>
            <th>Name</th>
            <th>Class</th>
            <th>Status</th>
            <th>Signature</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($attendances as $attendance)
            <tr>
              <td>{{ $attendance->date }}</td>
              <td>{{ $attendance->student->name }}</td>
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

      $('#date, #name, #class').change(() => {
        $('#formHistory').submit();
      });
    });
  </script>
@endsection --}}


@extends('guru.template.template')

@section('title', 'History Absensi')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">History Absensi</h6>
            {{-- tombol ekspor bisa ditambahkan nanti --}}
        </div>

        <div class="card-body">
            {{-- Filter --}}
            <form action="{{ route('guru.history') }}" method="get" id="formHistory" class="mb-4">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="small font-weight-bold">Tanggal</label>
                        <input type="date" name="date" id="date" class="form-control form-control-sm"
                            value="{{ request('date') }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="small font-weight-bold">Nama Siswa</label>
                        <input type="text" name="name" id="name" class="form-control form-control-sm"
                            placeholder="Cari nama..." value="{{ request('name') }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="small font-weight-bold">Kelas</label>
                        <select name="class" id="class" class="form-control form-control-sm">
                            <option value="">Pilih Kelas</option>
                            @foreach ($classes as $class)
                                <option value="{{ $class->id }}" {{ request('class') == $class->id ? 'selected' : '' }}>
                                    {{ $class->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
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

@section('script')
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
                        sNext: "›",
                        sPrevious: "‹"
                    }
                }
            });

            // auto submit saat filter berubah
            $('#date, #name, #class').on('change', () => $('#formHistory').submit());
        });
    </script>
@endsection
