@extends('admin.layouts.master')

@section('title', 'Data Walimurid')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-green-custom">Tabel Walimurid</h6>
            <button class="btn btn-primary btn-sm" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTambah">
                + Tambah Walimurid
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="text-center">
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Telpon</th>
                            <th>Email</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($walimurid as $i => $wm)
                            <tr>
                                <td class="text-center">{{ $i + 1 }}</td>
                                <td>{{ $wm->nama_walimurid }}</td>
                                <td>{{ $wm->telpon_walimurid }}</td>
                                <td>{{ $wm->email_walimurid }}</td>
                                <td>{{ $wm->alamat_walimurid }}</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="offcanvas"
                                        data-bs-target="#offcanvasEdit{{ $wm->id }}">Edit</button>
                                    <form action="{{ route('walimurid.destroy', $wm->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEdit{{ $wm->id }}"
                                aria-labelledby="offcanvasEditLabel{{ $wm->id }}">
                                <div class="offcanvas-header">
                                    <h5 id="offcanvasEditLabel{{ $wm->id }}" class="offcanvas-title">Edit Walimurid
                                    </h5>
                                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                        aria-label="Close"></button>
                                </div>
                                <div class="offcanvas-body">
                                    <form action="{{ route('walimurid.update', $wm->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="mb-3">
                                            <label for="nama_walimurid" class="form-label">Nama</label>
                                            <input type="text" class="form-control" name="nama_walimurid"
                                                value="{{ $wm->nama_walimurid }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="telpon_walimurid" class="form-label">Telepon</label>
                                            <input type="text" class="form-control" name="telpon_walimurid"
                                                value="{{ $wm->telpon_walimurid }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="email_walimurid" class="form-label">Email</label>
                                            <input type="email" class="form-control" name="email_walimurid"
                                                value="{{ $wm->email_walimurid }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="alamat_walimurid" class="form-label">Alamat</label>
                                            <textarea class="form-control" name="alamat_walimurid">{{ $wm->alamat_walimurid }}</textarea>
                                        </div>
                                        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasTambah" aria-labelledby="offcanvasTambahLabel">
        <div class="offcanvas-header">
            <h5 id="offcanvasTambahLabel" class="offcanvas-title">Tambah Walimurid</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form action="{{ route('walimurid.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="nama_walimurid" class="form-label">Nama</label>
                    <input type="text" class="form-control" name="nama_walimurid" required>
                </div>
                <div class="mb-3">
                    <label for="telpon_walimurid" class="form-label">Telepon</label>
                    <input type="text" class="form-control" name="telpon_walimurid">
                </div>
                <div class="mb-3">
                    <label for="email_walimurid" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email_walimurid">
                </div>
                <div class="mb-3">
                    <label for="alamat_walimurid" class="form-label">Alamat</label>
                    <textarea class="form-control" name="alamat_walimurid"></textarea>
                </div>
                <button type="submit" class="btn btn-success">Simpan</button>
            </form>
        </div>
    </div>

@endsection
