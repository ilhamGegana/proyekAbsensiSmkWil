@extends('guru.template.template')

@section('title', 'Jadwal Pelajaran')
@section('page-title', 'Jadwal Pelajaran')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Jadwal Pelajaran</h6>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead class="text-center">
                    <tr>
                        <th>Jam Ke</th>
                        <th>Kelas</th>
                        @foreach ($hariList as $hari)
                        <th>{{ $hari }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @forelse ($grouped as $jam => $kelasGroup)
                    @foreach ($kelasGroup as $kelas => $hariMapel)
                    <tr>
                        <td class="text-center">{{ $jam }}</td>
                        <td class="text-center">{{ $kelas }}</td>
                        @foreach ($hariList as $hari)
                        <td class="text-center">
                            {{ $hariMapel[$hari] ?? '-' }}
                        </td>
                        @endforeach
                    </tr>
                    @endforeach
                    @empty
                    <tr>
                        <td colspan="{{ 2 + count($hariList) }}" class="text-center">Tidak ada jadwal.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(function() {
        $('#dataTable').DataTable({
            pageLength: 10,
            responsive: true
        });
    });
</script>
@endsection