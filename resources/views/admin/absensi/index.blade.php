@extends('admin.layouts.master')

@section('title', 'Data Absensi')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-green-custom">Data Absensi</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="text-center">
                        <tr>
                            <th>#</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Hari</th>
                            <th>Mapel</th>
                            <th>Status</th>
                            <th>Waktu</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($absensi as $i => $a)
                            <tr>
                                <td class="text-center">{{ $i + 1 }}</td>
                                <td>{{ $a->siswa->nama_siswa ?? '-' }}</td>
                                <td>{{ $a->jadwal->kelas->nama_kelas ?? '-' }}</td>
                                <td>{{ $a->jadwal->hari ?? '-' }}</td>
                                <td>{{ $a->jadwal->mapel->nama_mapel ?? '-' }}</td>
                                <td>{{ ucfirst($a->status_absen) }}</td>
                                <td>{{ $a->tgl_waktu_absen }}</td>
                                <td>{{ $a->keterangan ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
