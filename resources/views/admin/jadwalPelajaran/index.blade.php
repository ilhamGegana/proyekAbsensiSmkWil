@extends('layouts.master')

@section('title', 'Jadwal Pelajaran')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header d-flex justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Jadwal Pelajaran</h6>
        <a href="{{ route('jadwalPelajaran.create') }}" class="btn btn-primary btn-sm">+ Tambah Jadwal</a>
    </div>
    <div class="card-body">
        <table class="table table-bordered" id="dataTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Hari</th>
                    <th>Kelas</th>
                    <th>Mapel</th>
                    <th>Guru</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($jadwal as $i => $j)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $j->hari }}</td>
                    <td>{{ $j->kelas->nama_kelas ?? '-' }}</td>
                    <td>{{ $j->mapel->nama_mapel ?? '-' }}</td>
                    <td>{{ $j->guru->nama_guru ?? '-' }}</td>
                    <td>
                        <a href="{{ route('jadwalPelajaran.edit', $j->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('jadwalPelajaran.destroy', $j->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
