@extends('admin.layouts.master')

@section('title', 'Data Siswa')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-green-custom">Data Siswa</h6>
            <button class="btn btn-primary btn-sm" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTambahSiswa">+ Tambah Siswa</button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="text-center">
                        <tr>
                            <th>#</th>
                            <th>NIS</th>
                            <th>Nama</th>
                            <th>Jenis Kelamin</th>
                            <th>Kelas</th>
                            <th>No. Telp</th>
                            <th>Tgl Lahir</th>
                            <th>Alamat</th>
                            <th>Walimurid</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($siswa as $i => $s)
                            <tr>
                                <td class="text-center">{{ $i + 1 }}</td>
                                <td>{{ $s->nis }}</td>
                                <td>{{ $s->nama_siswa }}</td>
                                <td class="text-center">{{ $s->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                <td>{{ $s->kelas->nama_kelas ?? '-' }}</td>
                                <td>{{ $s->no_telp_siswa ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($s->tgl_lahir)->translatedFormat('d F Y') ?? '-' }}</td>
                                <td>{{ $s->alamat_siswa ?? '-' }}</td>
                                <td>{{ $s->walimurid->nama_walimurid ?? '-' }}</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="offcanvas"
                                        data-bs-target="#offcanvasEditSiswa{{ $s->id }}">Edit</button>
                                    <form action="{{ route('siswa.destroy', $s->id) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Yakin ingin menghapus siswa ini?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Offcanvas Edit Siswa -->
                            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEditSiswa{{ $s->id }}">
                                <div class="offcanvas-header">
                                    <h5 class="offcanvas-title">Edit Siswa</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                                </div>
                                <div class="offcanvas-body">
                                    <form action="{{ route('siswa.update', $s->id) }}" method="POST">
                                        @csrf @method('PUT')
                                        <div class="mb-3">
                                            <label>NIS</label>
                                            <input type="text" name="nis" class="form-control"
                                                value="{{ $s->nis }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label>Nama Siswa</label>
                                            <input type="text" name="nama_siswa" class="form-control"
                                                value="{{ $s->nama_siswa }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label>Jenis Kelamin</label>
                                            <select name="jenis_kelamin" class="form-control" required>
                                                <option value="L" {{ $s->jenis_kelamin == 'L' ? 'selected' : '' }}>
                                                    Laki-laki</option>
                                                <option value="P" {{ $s->jenis_kelamin == 'P' ? 'selected' : '' }}>
                                                    Perempuan</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label>Kelas</label>
                                            <select name="id_kelas" class="select2" required>
                                                <option value="">-- Pilih atau cari kelas --</option>
                                                @foreach ($kelas as $k)
                                                    <option value="{{ $k->id }}"
                                                        {{ $s->id_kelas == $k->id ? 'selected' : '' }}>
                                                        {{ $k->nama_kelas }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label>No. Telp</label>
                                            <input type="text" name="no_telp_siswa" class="form-control"
                                                value="{{ $s->no_telp_siswa }}">
                                        </div>
                                        <div class="mb-3">
                                            <label>Tanggal Lahir</label>
                                            <input type="date" name="tgl_lahir" class="form-control"
                                                value="{{ $s->tgl_lahir }}">
                                        </div>
                                        <div class="mb-3">
                                            <label>Alamat</label>
                                            <textarea name="alamat_siswa" class="form-control" rows="2">{{ $s->alamat_siswa }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label>Walimurid</label>
                                            <select name="id_walimurid" class="select2">
                                                <option value="">-- Pilih atau cari walimurid --</option>
                                                @foreach ($walimurid as $w)
                                                    <option value="{{ $w->id }}"
                                                        {{ $s->id_walimurid == $w->id ? 'selected' : '' }}>
                                                        {{ $w->nama_walimurid }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Offcanvas Tambah Siswa -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasTambahSiswa">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">Tambah Siswa</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <form action="{{ route('siswa.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label>NIS</label>
                    <input type="text" name="nis" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Nama Siswa</label>
                    <input type="text" name="nama_siswa" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-control" required>
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Kelas</label>
                    <select name="id_kelas" class="select2" required>
                        <option value="">-- Pilih atau cari kelas --</option>
                        @foreach ($kelas as $k)
                            <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label>No. Telp</label>
                    <input type="text" name="no_telp_siswa" class="form-control">
                </div>
                <div class="mb-3">
                    <label>Tanggal Lahir</label>
                    <input type="date" name="tgl_lahir" class="form-control">
                </div>
                <div class="mb-3">
                    <label>Alamat</label>
                    <textarea name="alamat_siswa" class="form-control" rows="2"></textarea>
                </div>
                <div class="mb-3">
                    <label>Walimurid</label>
                    <select name="id_walimurid" class="select2">
                        <option value="">-- Pilih atau cari walimurid --</option>
                        @foreach ($walimurid as $w)
                            <option value="{{ $w->id }}">{{ $w->nama_walimurid }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-success">Simpan</button>
            </form>
        </div>
    </div>
@endsection
