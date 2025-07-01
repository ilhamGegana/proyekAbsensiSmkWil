@extends('guru.template.template')

@section('title', 'History Absensi')
@section('page-title', 'History Absensi')

@section('content')
<div class="card shadow mb-4">
  <div class="card-header font-weight-bold text-green-custom">
    History Absensi
  </div>
  <div class="card-body">
    {{-- FILTER --}}
    <form id="formHistory" method="get" class="row gx-2 mb-4">
      {{-- Rentang Tanggal --}}
      <div class="col-md-4">
        <label class="small">Tanggal (dari – sampai)</label>
        <div class="d-flex gap-1">
          <input type="date" name="from" class="form-control form-control-sm"
            value="{{ $from }}">
          <span class="align-self-center">–</span>
          <input type="date" name="to" class="form-control form-control-sm"
            value="{{ $to }}">
        </div>
      </div>
      {{-- Pilih Minggu --}}
      <div class="col-md-4">
        <label class="small">Minggu ke-</label>
        <select name="week" class="form-control form-control-sm">
          <option value="">-- Semua --</option>
          @for ($i = 1; $i <= 5; $i++)
            <option value="{{ $i }}" {{ request('week') == $i ? 'selected' : '' }}>
            Minggu ke-{{ $i }}
            </option>
            @endfor
        </select>
      </div>
      {{-- Nama Siswa --}}
      <div class="col-md-4">
        <label class="small">Nama Siswa</label>
        <input type="text" name="name" class="form-control form-control-sm"
          placeholder="Cari nama..." value="{{ $name }}">
      </div>
      {{-- Pilih Kelas --}}
      <div class="col-md-4">
        <label class="small">Kelas</label>
        <select name="class" class="form-control form-control-sm">
          <option value="">Semua Kelas Hari Ini</option>
          @foreach($classes as $c)
          <option value="{{ $c->id }}"
            {{ $c->id == $kelas ? 'selected' : '' }}>
            {{ $c->nama_kelas }}
          </option>
          @endforeach
        </select>
      </div>
    </form>

    {{-- TABEL SUMMARY --}}
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable">
        <thead class="text-center">
          <tr>
            <th>#</th>
            <th>Nama Siswa</th>
            <th>Kelas</th>
            <th>Alpha</th>
            <th>Sakit</th>
            <th>Izin</th>
          </tr>
        </thead>
        <tbody>
          @foreach($students as $i => $s)
          <tr>
            <td class="text-center">{{ $i + 1 }}</td>
            <td>{{ $s->nama_siswa }}</td>
            <td>{{ $s->kelas->nama_kelas }}</td>
            <td class="text-center">{{ $s->alpha_count }}</td>
            <td class="text-center">{{ $s->sakit_count }}</td>
            <td class="text-center">{{ $s->izin_count }}</td>
          </tr>
          @endforeach
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
      ordering: true,
      responsive: true,
      language: {
        sEmptyTable: "Tidak ada data",
        sInfo: "_START_-_END_ dari _TOTAL_ entri",
        sInfoEmpty: "0-0 dari 0 entri",
        sInfoFiltered: "(disaring dari _MAX_ entri)",
        sLengthMenu: "Tampilkan _MENU_ entri",
        sSearch: "Cari:",
        oPaginate: {
          sFirst: "Pertama",
          sLast: "Terakhir",
          sNext: ">",
          sPrevious: "<"
        }
      }
    });

    // auto-submit filter saat input/select berubah
    $('#formHistory').on('change', 'input,select', function() {
      $('#formHistory').submit();
    });
  });
</script>
@endsection