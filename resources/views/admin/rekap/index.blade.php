@extends('admin.layouts.master')

@section('title', 'Rekap Absensi')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Rekap Absensi</h1>

    <div class="card mb-4">
        <div class="card-header">Filter Data</div>
        <div class="card-body">
            <form action="{{ route('rekap.index') }}" method="GET">
                <div class="row">
                    <div class="col-md-4 mb-2">
                        <label for="tanggal">Tanggal</label>
                        <input type="date" name="tanggal" id="tanggal" class="form-control"
                            value="{{ request('tanggal') }}">
                    </div>
                    <div class="col-md-4 mb-2">
                        <label for="kelas">Kelas</label>
                        <select name="kelas" id="kelas" class="form-control">
                            <option value="">-- Semua Kelas --</option>
                            {{-- Nanti populate dari controller --}}
                        </select>
                    </div>
                    <div class="col-md-4 d-flex align-items-end mb-2">
                        <button class="btn btn-primary me-2" type="submit">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                        <a href="{{ route('rekap.download', request()->all()) }}" class="btn btn-success">
                            <i class="fas fa-file-download"></i> Download PDF
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if (count($data) > 0)
        <div class="card">
            <div class="card-header">Hasil Rekap</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nama Siswa</th>
                                <th>Kelas</th>
                                <th>Tanggal</th>
                                <th>Jam Pelajaran</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $item->siswa->nama }}</td>
                                    <td>{{ $item->siswa->kelas->nama }}</td>
                                    <td>{{ $item->tanggal }}</td>
                                    <td>{{ $item->jam_pelajaran }}</td>
                                    <td>{{ $item->status }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
@endsection
