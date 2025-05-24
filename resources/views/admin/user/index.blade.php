@extends('admin.layouts.master')

@section('title', 'Data User')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-green-custom">Data User</h6>
            <button class="btn btn-primary btn-sm" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTambah">+ Tambah
                User</button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%">
                    <thead class="text-center">
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
                        @foreach ($user as $i => $u)
                            <tr>
                                <td class="text-center">{{ $i + 1 }}</td>
                                <td>{{ $u->username }}</td>
                                <td>{{ ucfirst($u->role) }}</td>
                                <td class="text-center">
                                    <span class="badge badge-{{ $u->status_aktif ? 'success' : 'danger' }}">
                                        {{ $u->status_aktif ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td>
                                    @if ($u->siswa)
                                        {{ $u->siswa->nama_siswa }}
                                    @elseif($u->guru)
                                        {{ $u->guru->nama_guru }}
                                    @elseif($u->walimurid)
                                        {{ $u->walimurid->nama_walimurid }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="offcanvas"
                                        data-bs-target="#offcanvasEdit{{ $u->id }}">Edit</button>
                                    <form action="{{ route('user.destroy', $u->id) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Yakin ingin menghapus?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Offcanvas Edit -->
                            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEdit{{ $u->id }}">
                                <div class="offcanvas-header">
                                    <h5 class="offcanvas-title">Edit User</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                                </div>
                                <div class="offcanvas-body">
                                    <form action="{{ route('user.update', $u->id) }}" method="POST">
                                        @csrf @method('PUT')
                                        <div class="mb-3">
                                            <label>Username</label>
                                            <input type="text" name="username" value="{{ $u->username }}"
                                                class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label>Password (Kosongkan jika tidak diubah)</label>
                                            <input type="password" name="password" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label>Role</label>
                                            <input type="text" class="form-control" value="{{ ucfirst($u->role) }}"
                                                readonly>
                                            <input type="hidden" name="role" value="{{ $u->role }}">
                                        </div>
                                        <div class="mb-3">
                                            <label>Status Aktif</label>
                                            <select name="status_aktif" class="form-control">
                                                <option value="1" {{ $u->status_aktif ? 'selected' : '' }}>Aktif
                                                </option>
                                                <option value="0" {{ !$u->status_aktif ? 'selected' : '' }}>Nonaktif
                                                </option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label>Nama Terkait</label>
                                            <input type="text" class="form-control"
                                                value="{{ $u->siswa->nama_siswa ?? ($u->guru->nama_guru ?? ($u->walimurid->nama_walimurid ?? '-')) }}"
                                                readonly>
                                            <input type="hidden" name="id_terkait"
                                                value="{{ $u->id_siswa ?? ($u->id_guru ?? $u->id_walimurid) }}">
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
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasTambah">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">Tambah User</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <form action="{{ route('user.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Role</label>
                    <select name="role" class="form-control" id="roleSelect" required>
                        <option value="">-- Pilih Role --</option>
                        <option value="admin">Admin</option>
                        <option value="guru">Guru</option>
                        <option value="siswa">Siswa</option>
                        <option value="walimurid">Walimurid</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Status Aktif</label>
                    <select name="status_aktif" class="form-control">
                        <option value="1">Aktif</option>
                        <option value="0">Nonaktif</option>
                    </select>
                </div>
                <div class="mb-3" id="divIdTerkait" style="display: none">
                    <label>Nama Terkait</label>
                    <select name="id_terkait" id="idTerkaitSelect" class="form-control select2">
                        <option value="">-- Pilih Nama --</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success">Simpan</button>
            </form>
        </div>
    </div>
@endsection
<script>
    function loadTerkaitSelect(role, targetSelect, selected = '') {
        if (role === 'guru' || role === 'siswa' || role === 'walimurid') {
            fetch(`{{ url('/user/terkait') }}/${role}`)
                .then(res => res.json())
                .then(data => {
                    let options = `<option value="">-- Pilih Nama --</option>`;
                    data.forEach(item => {
                        const isSelected = item.id == selected ? 'selected' : '';
                        options += `<option value="${item.id}" ${isSelected}>${item.nama}</option>`;
                    });
                    targetSelect.innerHTML = options;
                    $(targetSelect).select2({
                        dropdownParent: $(targetSelect).closest('.offcanvas')
                    });
                });
        } else {
            targetSelect.innerHTML = '';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Tambah User
        const roleSelect = document.getElementById('roleSelect');
        const idTerkaitSelect = document.getElementById('idTerkaitSelect');
        const divIdTerkait = document.getElementById('divIdTerkait');

        $(idTerkaitSelect).select2({
            dropdownParent: $('#offcanvasTambah')
        });

        roleSelect.addEventListener('change', function() {
            const role = roleSelect.value;
            if (role === 'guru' || role === 'siswa' || role === 'walimurid') {
                divIdTerkait.style.display = 'block';
                loadTerkaitSelect(role, idTerkaitSelect);
            } else {
                divIdTerkait.style.display = 'none';
                idTerkaitSelect.innerHTML = '';
            }
        });

        // Edit User (loop semua select-terkait)
        document.querySelectorAll('.select-terkait').forEach(select => {
            const role = select.dataset.role;
            const selected = select.dataset.selected;
            loadTerkaitSelect(role, select, selected);
        });
    });
</script>
