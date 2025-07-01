<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Rekap Absensi</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 11px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 4px;
            text-align: left;
        }

        th {
            background-color: #eee;
        }

        h2 {
            text-align: center;
            margin-bottom: 0;
        }

        .section-title {
            margin-top: 30px;
        }
    </style>
</head>

<body>
    <h2>Rekap Absensi</h2>

    {{-- TABEL DETAIL ABSENSI --}}
    <table>
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
                <td>{{ $item->siswa->nama_siswa ?? '-' }}</td>
                <td>{{ $item->siswa->kelas->nama_kelas ?? '-' }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tgl_waktu_absen)->format('d/m/Y') }}</td>
                <td>{{ $item->jadwal->jam_ke ?? '-' }}</td>
                <td>{{ ucfirst($item->status_absen) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- TABEL REKAP ASI --}}
    @if(isset($rekapASI) && count($rekapASI) > 0)
    <h3 class="section-title">Rekap ASI (Alpha, Sakit, Izin)</h3>
    <table>
        <thead>
            <tr>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Alpha</th>
                <th>Sakit</th>
                <th>Izin</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rekapASI as $siswa)
            <tr>
                <td>{{ $siswa->nama_siswa }}</td>
                <td>{{ $siswa->kelas->nama_kelas ?? '-' }}</td>
                <td>{{ $siswa->alpha_count }}</td>
                <td>{{ $siswa->sakit_count }}</td>
                <td>{{ $siswa->izin_count }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</body>

</html>