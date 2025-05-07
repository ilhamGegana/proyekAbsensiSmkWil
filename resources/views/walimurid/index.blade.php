@extends('layouts.master')

@section('title', 'Data Walimurid')

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Data Walimurid</h1>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<a href="{{ route('walimurid.create') }}" class="btn btn-primary mb-3">+ Tambah Walimurid</a>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Tabel Walimurid</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Telpon</th>
                        <th>Email</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($walimurid as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->nama_walimurid }}</td>
                        <td>{{ $item->telpon_walimurid }}</td>
                        <td>{{ $item->email_walimurid }}</td>
                        <td>{{ $item->alamat_walimurid }}</td>
                        <td>
                            <a href="{{ route('walimurid.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('walimurid.destroy', $item->id) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
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
