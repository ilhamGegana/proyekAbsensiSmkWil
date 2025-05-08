@extends('layouts.master')

@section('title', 'Data Guru')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Data Guru</h6>
        <a href="{{ route('guru.create') }}" class="btn btn-primary btn-sm">+ Tambah Guru</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable">
                <thead class="text-center">
                    <tr>
                        <th>#</th>
                        <th>NIP</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Telp</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($guru as $i => $g)
                    <tr>
                        <td class="text-center">{{ $i + 1 }}</td>
                        <td>{{ $g->nip ?? '-' }}</td>
                        <td>{{ $g->nama_guru }}</td>
                        <td>{{ $g->email_guru ?? '-' }}</td>
                        <td>{{ $g->telpon_guru ?? '-' }}</td>
                        <td class="text-center">
                            <a href="{{ route('guru.edit', $g->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('guru.destroy', $g->id) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Yakin ingin menghapus guru ini?')">
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
</div>
@endsection
