<!DOCTYPE html>
<html>

<head>
    <title>Jadwal Pelajaran</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
            padding: 5px;
            text-align: left;
        }
    </style>
</head>

<body>
    <h2>Jadwal Pelajaran</h2>
    <table>
        <thead>
            <tr>
                <th>Hari</th>
                <th>Jam Ke</th>
                <th>Kelas</th>
                <th>Mata Pelajaran</th>
                <th>Guru</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($jadwalPelajaran as $jadwal)
            <tr>
                <td>{{ $jadwal->hari }}</td>
                <td>{{ $jadwal->jam_ke }}</td>
                <td>{{ $jadwal->kelas->nama_kelas }}</td>
                <td>{{ $jadwal->mapel->nama_mapel }}</td>
                <td>{{ $jadwal->guru->nama_guru }}</td>
                <td>{{ $jadwal->is_active ? 'Aktif' : 'Nonaktif' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>