@extends('admin.layouts.master')

@section('title', 'Jadwal Pelajaran')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-green-custom">Jadwal Pelajaran</h6>
            <button class="btn btn-primary btn-sm" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTambahJadwal">+ Tambah
                Jadwal</button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="text-center">
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
                        @foreach ($jadwalPelajaran as $i => $j)
                            <tr>
                                <td class="text-center">{{ $i + 1 }}</td>
                                <td>{{ $j->hari }}</td>
                                <td>{{ $j->kelas->nama_kelas ?? '-' }}</td>
                                <td>{{ $j->mapel->nama_mapel ?? '-' }}</td>
                                <td>{{ $j->guru->nama_guru ?? '-' }}</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="offcanvas"
                                        data-bs-target="#offcanvasEditJadwal{{ $j->id }}">Edit</button>
                                    <form action="{{ route('jadwalPelajaran.destroy', $j->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Offcanvas Edit -->
                            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEditJadwal{{ $j->id }}">
                                <div class="offcanvas-header">
                                    <h5 class="offcanvas-title">Edit Jadwal</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                                </div>
                                <div class="offcanvas-body">
                                    <form action="{{ route('jadwalPelajaran.update', $j->id) }}" method="POST">
                                        @csrf @method('PUT')
                                        <div class="mb-3">
                                            <label>Hari</label>
                                            <select name="hari" class="form-control" required>
                                                @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $hari)
                                                    <option value="{{ $hari }}"
                                                        {{ $j->hari == $hari ? 'selected' : '' }}>{{ $hari }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label>Kelas</label>
                                            <select name="id_kelas" class="form-control select2" required>
                                                <option value="">-- Pilih Kelas --</option>
                                                @foreach ($kelas as $k)
                                                    <option value="{{ $k->id }}"
                                                        {{ $j->id_kelas == $k->id ? 'selected' : '' }}>
                                                        {{ $k->nama_kelas }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label>Mapel</label>
                                            <select name="id_mapel" class="form-control select2" required>
                                                <option value="">-- Pilih Mapel --</option>
                                                @foreach ($mapel as $m)
                                                    <option value="{{ $m->id }}"
                                                        {{ $j->id_mapel == $m->id ? 'selected' : '' }}>
                                                        {{ $m->nama_mapel }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label>Guru</label>
                                            <select name="id_guru" class="form-control select2" required>
                                                <option value="">-- Pilih Guru --</option>
                                                @foreach ($guru as $g)
                                                    <option value="{{ $g->id }}"
                                                        {{ $j->id_guru == $g->id ? 'selected' : '' }}>{{ $g->nama_guru }}
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

    <!-- Offcanvas Tambah -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasTambahJadwal">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">Tambah Jadwal</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <form action="{{ route('jadwalPelajaran.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label>Hari</label>
                    <select name="hari" class="form-control" required>
                        <option value="">-- Pilih Hari --</option>
                        @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $hari)
                            <option value="{{ $hari }}">{{ $hari }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label>Kelas</label>
                    <select name="id_kelas" class="form-control select2" required>
                        <option value="">-- Pilih Kelas --</option>
                        @foreach ($kelas as $k)
                            <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label>Mapel</label>
                    <select name="id_mapel" class="form-control select2" required>
                        <option value="">-- Pilih Mapel --</option>
                        @foreach ($mapel as $m)
                            <option value="{{ $m->id }}">{{ $m->nama_mapel }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label>Guru</label>
                    <select name="id_guru" class="form-control select2" required>
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
