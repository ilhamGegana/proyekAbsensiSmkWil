@extends('layouts.master')

@section('title', 'Data Absensi')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header">
        <h6 class="m-0 font-weight-bold text-primary">Data Absensi</h6>
    </div>
    <div class="card-body">
        <table class="table table-bordered" id="dataTable">
            <thead>
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
                @foreach($absensi as $i => $a)
                <tr>
                    <td>{{ $i + 1 }}</td>
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
@endsection
