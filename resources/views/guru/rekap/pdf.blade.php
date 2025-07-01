<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Rekap Absensi</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }

        th {
            background-color: #eee;
        }

        h2 {
            text-align: center;
        }

        .section {
            margin-top: 30px;
        }
    </style>
</head>

<body>
    <h2>Rekap Absensi</h2>

    <div class="section">
        <h4>Detail Absensi</h4>
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
    </div>

    @if($rekapASI->count())
    <div class="section">
        <h4>Rekap ASI (Alpha, Sakit, Izin)</h4>
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
    </div>
    @endif
</body>

</html>