@extends('guru.template.template')
@section('title', 'Daftar Siswa & Status Absen')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header font-weight-bold text-primary">Daftar Siswa –
            {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</div>

        <div class="card-body">
            {{-- Filter --}}
            <form action="{{ route('guru.students.index') }}" method="get" id="formFilter" class="mb-4">
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <input type="date" name="date" id="date" class="form-control form-control-sm"
                            value="{{ $date }}">
                    </div>
                    <div class="col-md-3 mb-2">
                        <input type="text" name="name" id="name" class="form-control form-control-sm"
                            placeholder="Cari nama…" value="{{ request('name') }}">
                    </div>
                    <div class="col-md-3 mb-2">
                        <select name="class" id="class" class="form-control form-control-sm">
                            <option value="">Pilih Kelas</option>
                            @foreach ($classes as $kelas)
                                <option value="{{ $kelas->id }}" {{ request('class') == $kelas->id ? 'selected' : '' }}>
                                    {{ $kelas->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>

            {{-- Tabel --}}
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
                                $color =
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
                                <td>{{ $student->nis }}</td>
                                <td>{{ $student->nama_siswa }}</td>
                                <td>{{ $student->kelas->nama_kelas ?? '-' }}</td>
                                <td class="text-center">
                                    <span class="btn btn-sm btn-{{ $color }}">{{ ucfirst($status) }}</span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('guru.students.edit', [$student->id, 'date' => $date]) }}"
                                        class="btn btn-sm btn-secondary">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
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
            $('#date,#name,#class').on('change', () => $('#formFilter').submit());
        });
    </script>
@endsection
