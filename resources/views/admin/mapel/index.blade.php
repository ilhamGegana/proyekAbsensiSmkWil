@extends('layouts.master')

@section('title', 'Data Mapel')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header d-flex justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Data Mapel</h6>
        <a href="{{ route('mapel.create') }}" class="btn btn-primary btn-sm">+ Tambah Mapel</a>
    </div>
    <div class="card-body">
        <table class="table table-bordered" id="dataTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Mapel</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($mapel as $i => $m)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $m->nama_mapel }}</td>
                    <td>
                        <a href="{{ route('mapel.edit', $m->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('mapel.destroy', $m->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
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
