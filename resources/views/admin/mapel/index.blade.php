@extends('admin.layouts.master')

@section('title', 'Data Mapel')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-green-custom">Data Mapel</h6>
            <button class="btn btn-primary btn-sm" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTambah">+ Tambah
                Mapel</button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="text-center">
                        <tr>
                            <th>#</th>
                            <th>Nama Mapel</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($mapel as $i => $m)
                            <tr>
                                <td class="text-center">{{ $i + 1 }}</td>
                                <td class="text-center">{{ $m->nama_mapel }}</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="offcanvas"
                                        data-bs-target="#offcanvasEdit{{ $m->id }}">
                                        Edit
                                    </button>
                                    <form action="{{ route('mapel.destroy', $m->id) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Yakin ingin menghapus?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            <!-- Offcanvas Edit -->
                            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEdit{{ $m->id }}"
                                aria-labelledby="offcanvasEditLabel{{ $m->id }}">
                                <div class="offcanvas-header">
                                    <h5 class="offcanvas-title" id="offcanvasEditLabel{{ $m->id }}">Edit Mapel</h5>
                                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                        aria-label="Close"></button>
                                </div>
                                <div class="offcanvas-body">
                                    <form action="{{ route('mapel.update', $m->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="mb-3">
                                            <label for="nama_mapel{{ $m->id }}" class="form-label">Nama Mapel</label>
                                            <input type="text" name="nama_mapel" id="nama_mapel{{ $m->id }}"
                                                value="{{ $m->nama_mapel }}" class="form-control" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Offcanvas Tambah -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasTambah" aria-labelledby="offcanvasTambahLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasTambahLabel">Tambah Mapel</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form action="{{ route('mapel.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="nama_mapel" class="form-label">Nama Mapel</label>
                    <input type="text" name="nama_mapel" id="nama_mapel" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success">Simpan</button>
            </form>
        </div>
    </div>
@endsection
