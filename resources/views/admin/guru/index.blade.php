@extends('admin.layouts.master')

@section('title', 'Data Guru')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-green-custom">Data Guru</h6>
            <button class="btn btn-primary btn-sm" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTambahGuru">
                + Tambah Guru
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
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
                        @foreach ($guru as $i => $g)
                            <tr>
                                <td class="text-center">{{ $i + 1 }}</td>
                                <td>{{ $g->nip ?? '-' }}</td>
                                <td>{{ $g->nama_guru }}</td>
                                <td>{{ $g->email_guru ?? '-' }}</td>
                                <td>{{ $g->telpon_guru ?? '-' }}</td>
                                <td class="text-center">
                                    <a href="#" class="btn btn-sm btn-warning" data-bs-toggle="offcanvas"
                                        data-bs-target="#offcanvasEditGuru{{ $g->id }}">Edit</a>
                                    <form action="{{ route('guru.destroy', $g->id) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Yakin ingin menghapus guru ini?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            <!-- Offcanvas Edit Guru -->
                            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEditGuru{{ $g->id }}"
                                aria-labelledby="offcanvasEditGuruLabel{{ $g->id }}">
                                <div class="offcanvas-header">
                                    <h5 class="offcanvas-title" id="offcanvasEditGuruLabel{{ $g->id }}">Edit Guru
                                    </h5>
                                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                        aria-label="Close"></button>
                                </div>
                                <div class="offcanvas-body">
                                    <form action="{{ route('guru.update', $g->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="mb-3">
                                            <label for="nip{{ $g->id }}" class="form-label">NIP</label>
                                            <input type="text" name="nip" id="nip{{ $g->id }}"
                                                class="form-control" value="{{ $g->nip }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="nama_guru{{ $g->id }}" class="form-label">Nama Guru <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="nama_guru" id="nama_guru{{ $g->id }}"
                                                class="form-control" value="{{ $g->nama_guru }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="email_guru{{ $g->id }}" class="form-label">Email</label>
                                            <input type="email" name="email_guru" id="email_guru{{ $g->id }}"
                                                class="form-control" value="{{ $g->email_guru }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="telpon_guru{{ $g->id }}" class="form-label">No Telp</label>
                                            <input type="text" name="telpon_guru" id="telpon_guru{{ $g->id }}"
                                                class="form-control" value="{{ $g->telpon_guru }}">
                                        </div>
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Offcanvas Tambah Guru -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasTambahGuru" aria-labelledby="offcanvasTambahGuruLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasTambahGuruLabel">Tambah Guru</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form action="{{ route('guru.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="nip" class="form-label">NIP/NUPTK</label>
                    <input type="text" name="nip" id="nip" class="form-control" value="{{ old('nip') }}">
                </div>
                <div class="mb-3">
                    <label for="nama_guru" class="form-label">Nama Guru <span class="text-danger">*</span></label>
                    <input type="text" name="nama_guru" id="nama_guru" class="form-control"
                        value="{{ old('nama_guru') }}" required>
                </div>
                <div class="mb-3">
                    <label for="email_guru" class="form-label">Email</label>
                    <input type="email" name="email_guru" id="email_guru" class="form-control"
                        value="{{ old('email_guru') }}">
                </div>
                <div class="mb-3">
                    <label for="telpon_guru" class="form-label">No Telp</label>
                    <input type="text" name="telpon_guru" id="telpon_guru" class="form-control"
                        value="{{ old('telpon_guru') }}">
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
@endsection
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editButtons = document.querySelectorAll('a.btn-warning');

        editButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                const url = this.getAttribute('href');

                fetch(url)
                    .then(res => res.json())
                    .then(data => {
                        // Set form action
                        const form = document.getElementById('editGuruForm');
                        form.setAttribute('action', `/guru/${data.id}`);

                        // Set input values
                        document.getElementById('edit_id').value = data.id;
                        document.getElementById('edit_nip').value = data.nip ?? '';
                        document.getElementById('edit_nama_guru').value = data.nama_guru;
                        document.getElementById('edit_email_guru').value = data
                            .email_guru ?? '';
                        document.getElementById('edit_telpon_guru').value = data
                            .telpon_guru ?? '';

                        // Show offcanvas
                        const offcanvas = new bootstrap.Offcanvas(document.getElementById(
                            'offcanvasEditGuru'));
                        offcanvas.show();
                    });
            });
        });
    });
</script>
