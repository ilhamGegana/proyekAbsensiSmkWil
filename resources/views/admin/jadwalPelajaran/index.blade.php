@extends('admin.layouts.master')

@section('title', 'Jadwal Pelajaran')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header d-flex justify-content-between">
        <h6 class="m-0 font-weight-bold text-green-custom">Jadwal Pelajaran</h6>
        <button class="btn btn-primary btn-sm" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTambahJadwal">
            + Tambah Jadwal
        </button>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead class="text-center">
                    <tr>
                        <th>#</th>
                        <th>Hari</th>
                        <th>Jam-ke</th>
                        <th>Kelas</th>
                        <th>Mapel</th>
                        <th>Guru</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jadwalPelajaran as $i => $j)
                    <tr class="{{ $j->is_active ? '' : 'table-secondary' }}">
                        <td class="text-center">{{ $i+1 }}</td>
                        <td>{{ $j->hari }}</td>
                        <td class="text-center">{{ $j->jam_ke }}</td>
                        <td>{{ $j->kelas->nama_kelas ?? '-' }}</td>
                        <td>{{ $j->mapel->nama_mapel ?? '-' }}</td>
                        <td>{{ $j->guru->nama_guru ?? '-' }}</td>
                        <td class="text-center">
                            <span class="badge {{ $j->is_active?'bg-success':'bg-secondary' }}">
                                {{ $j->is_active ? 'Aktif':'Non-aktif' }}
                            </span>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-warning"
                                data-bs-toggle="offcanvas"
                                data-bs-target="#offcanvasEditJadwal{{ $j->id }}">Edit
                            </button>

                            <!-- tombol toggle aktif/non-aktif -->
                            <form action="{{ route('jadwalPelajaran.toggle',$j->id) }}" method="POST"
                                class="d-inline"
                                onsubmit="return confirm('Yakin ingin mengubah status jadwal?')">
                                @csrf @method('PATCH')
                                @if($j->is_active)
                                <button class="btn btn-sm btn-danger">Nonaktifkan</button>
                                @else
                                <button class="btn btn-sm btn-success">Aktifkan</button>
                                @endif
                            </form>
                        </td>
                    </tr>

                    <!-- ============ OFFCANVAS EDIT ============ -->
                    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEditJadwal{{ $j->id }}">
                        <div class="offcanvas-header">
                            <h5 class="offcanvas-title">Edit Jadwal</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                        </div>
                        <div class="offcanvas-body">
                            <form action="{{ route('jadwalPelajaran.update',$j->id) }}" method="POST">
                                @csrf @method('PUT')

                                <div class="mb-3">
                                    <label>Hari</label>
                                    <select name="hari" class="form-control" required>
                                        @foreach (['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $hari)
                                        <option value="{{ $hari }}" {{ $j->hari==$hari?'selected':'' }}>{{ $hari }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label>Jam-ke</label>
                                    <input type="number" name="jam_ke" min="0" max="20"
                                        class="form-control" value="{{ old('jam_ke',$j->jam_ke) }}" required>
                                </div>

                                <div class="mb-3">
                                    <label>Kelas</label>
                                    <select name="id_kelas" class="form-control select2" required>
                                        <option value="">-- Pilih Kelas --</option>
                                        @foreach ($kelas as $k)
                                        <option value="{{ $k->id }}" {{ $j->id_kelas==$k->id?'selected':'' }}>
                                            {{ $k->nama_kelas }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label>Mapel</label>
                                    <select name="id_mapel" class="form-control select2 mapel-select" required>
                                        <option value="">-- Pilih Mapel --</option>
                                        @foreach ($mapel as $m)
                                        <option value="{{ $m->id }}"
                                            data-guru-id="{{ $m->id_guru }}"
                                            data-guru-name="{{ $m->guru?->nama_guru }}"
                                            {{ $j->id_mapel == $m->id ? 'selected' : '' }}>
                                            {{ $m->kode_mapel }} - {{ $m->nama_mapel }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- GURU (tampil + hidden id) --}}
                                <div class="mb-3">
                                    <label>Guru Pengampu</label>
                                    <input type="text" class="form-control-plaintext guru-name"
                                        value="{{ $j->guru->nama_guru ?? '-' }}" readonly>
                                    <input type="hidden" name="id_guru" value="{{ $j->id_guru }}">
                                </div>

                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox"
                                        id="isActive{{ $j->id }}" name="is_active"
                                        value="1" {{ $j->is_active?'checked':'' }}>
                                    <label class="form-check-label" for="isActive{{ $j->id }}">Jadwal Aktif</label>
                                </div>

                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>
                    </div>
                    <!-- ============ END OFFCANVAS EDIT ============ -->

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ============ OFFCANVAS TAMBAH ============ -->
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
                    @foreach (['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $hari)
                    <option value="{{ $hari }}">{{ $hari }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Jam-ke</label>
                <input type="number" name="jam_ke" min="0" max="20" class="form-control" required>
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
                <select name="id_mapel" class="form-control select2 mapel-select" required>
                    <option value="">-- Pilih Mapel --</option>
                    @foreach ($mapel as $m)
                    <option value="{{ $m->id }}"
                        data-guru-id="{{ $m->id_guru }}"
                        data-guru-name="{{ $m->guru?->nama_guru }}">
                        {{ $m->kode_mapel }} - {{ $m->nama_mapel }}
                    </option>
                    @endforeach
                </select>
            </div>

            {{-- GURU (tampil + hidden id) --}}
            <div class="mb-3">
                <label>Guru Pengampu</label>
                <input type="text" class="form-control-plaintext guru-name" value="-" readonly>
                <input type="hidden" name="id_guru">
            </div>

            <button type="submit" class="btn btn-success">Simpan</button>
        </form>
    </div>
</div>
<!-- ============ END OFFCANVAS TAMBAH ============ -->
<a href="{{ route('jadwal-pelajaran.download', request()->all()) }}" class="btn btn-danger ms-2">
    <i class="fas fa-file-pdf"></i> Download PDF
</a>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', () => {

        /** Update nama & id guru ketika mapel berubah */
        function syncGuru(sel) {
            const frm = sel.closest('form'); // cari form tempat select itu berada
            const txt = frm.querySelector('.guru-name'); // input readonly untuk menampilkan nama guru
            const hid = frm.querySelector('input[name="id_guru"]'); // hidden input untuk menyimpan ID guru

            const opt = sel.selectedOptions[0] || {}; // ambil <option> yang sedang dipilih
            const gId = opt.dataset.guruId || ''; //ambil atribut data-guru-id dari <option>
            const gNm = opt.dataset.guruName || '-'; // ambil atribut data-guru-name dari <option>

            if (txt) txt.value = gNm; // tampilkan nama guru ke input readonly
            if (hid) hid.value = gId; // set nilai hidden input dengan ID guru
        }

        // jalankan untuk setiap select mapel di halaman
        document.querySelectorAll('select.mapel-select').forEach(sel => {
            syncGuru(sel); // set nilai awal (saat form dibuka)
            sel.addEventListener('change', () => syncGuru(sel));
        });
    });
</script>