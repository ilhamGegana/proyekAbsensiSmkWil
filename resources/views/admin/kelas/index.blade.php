@extends('admin.layouts.master')

@section('title', 'Data Kelas')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-green-custom">Data Kelas</h6>
            <button class="btn btn-primary btn-sm" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTambah">+ Tambah
                Kelas</button>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="text-center">
                        <tr>
                            <th>#</th>
                            <th>Nama Kelas</th>
                            <th>Tingkat</th>
                            <th>Wali Kelas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kelas as $i => $k)
                            <tr>
                                <td class="text-center">{{ $i + 1 }}</td>
                                <td>{{ $k->nama_kelas }}</td>
                                <td>{{ $k->tingkat }}</td>
                                <td>{{ $k->guru->nama_guru ?? '-' }}</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="offcanvas"
                                        data-bs-target="#offcanvasEdit{{ $k->id }}">
                                        Edit
                                    </button>

                                    <form action="{{ route('kelas.destroy', $k->id) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Yakin ingin menghapus?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Offcanvas Edit -->
                            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEdit{{ $k->id }}"
                                aria-labelledby="offcanvasEditLabel{{ $k->id }}">
                                <div class="offcanvas-header">
                                    <h5 class="offcanvas-title" id="offcanvasEditLabel{{ $k->id }}">Edit Kelas</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                        aria-label="Close"></button>
                                </div>
                                <div class="offcanvas-body">
                                    <form action="{{ route('kelas.update', $k->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="mb-3">
                                            <label for="nama_kelas{{ $k->id }}" class="form-label">Nama
                                                Kelas</label>
                                            <input type="text" name="nama_kelas" id="nama_kelas{{ $k->id }}"
                                                value="{{ $k->nama_kelas }}" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="tingkat{{ $k->id }}" class="form-label">Tingkat</label>
                                            <input type="text" name="tingkat" id="tingkat{{ $k->id }}"
                                                value="{{ $k->tingkat }}" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="wali_kelas{{ $k->id }}" class="form-label">Wali
                                                Kelas</label>
                                            <select name="id_guru" id="wali_kelas{{ $k->id }}"
                                                class="form-control select2">
                                                <option value="">-- Pilih Guru --</option>
                                                @foreach ($guru as $g)
                                                    <option value="{{ $g->id }}"
                                                        {{ $k->id_guru == $g->id ? 'selected' : '' }}>{{ $g->nama_guru }}
                                                    </option>
                                                @endforeach
                                            </select>
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
            <h5 class="offcanvas-title" id="offcanvasTambahLabel">Tambah Kelas</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form action="{{ route('kelas.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="nama_kelas" class="form-label">Nama Kelas</label>
                    <input type="text" name="nama_kelas" id="nama_kelas" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="tingkat" class="form-label">Tingkat</label>
                    <input type="text" name="tingkat" id="tingkat" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="id_guru" class="form-label">Wali Kelas</label>
                    <select name="id_guru" id="id_guru" class="form-control select2">
                        <option value="">-- Pilih Guru --</option>
                        @foreach ($guru as $g)
                            <option value="{{ $g->id }}">{{ $g->nama_guru }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-success">Simpan</button>
            </form>
        </div>
    </div>
@endsection
