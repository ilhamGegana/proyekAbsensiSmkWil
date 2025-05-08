@extends('layouts.master')

@section('title', 'Data User')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header d-flex justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Data User</h6>
        <a href="{{ route('user.create') }}" class="btn btn-primary btn-sm">+ Tambah User</a>
    </div>
    <div class="card-body">
        <table class="table table-bordered" id="dataTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Nama Terkait</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $i => $u)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $u->username }}</td>
                    <td>{{ ucfirst($u->role) }}</td>
                    <td>
                        <span class="badge badge-{{ $u->status_aktif ? 'success' : 'danger' }}">
                            {{ $u->status_aktif ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td>
                        @if($u->siswa)
                            {{ $u->siswa->nama_siswa }}
                        @elseif($u->guru)
                            {{ $u->guru->nama_guru }}
                        @elseif($u->walimurid)
                            {{ $u->walimurid->nama_walimurid }}
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('user.edit', $u->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('user.destroy', $u->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
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
