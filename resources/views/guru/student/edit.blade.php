@extends('guru/template/template')

@section('style')
<style>
  #attendanceTable {
    font-size: 24px;
    font-weight: 400;
  }

  .btn-update {
    background-color: #294A9B;
    color: white;
    width: 297px;
    font-size: 24px;
    font-weight: 400;
    height: 84px;
  }

  .label-student {
    font-size: 24px;
    font-weight: 400;
  }

  .card-header {
    min-height: 112px;
    color: white;
    background-color: white;
  }

  .card-footer {
    min-height: 112px;
    color: white;
    background-color: white;
  }
</style>
@endsection

@section('title', 'Ubah Status Absen')

@section('content')
<div class="card shadow mb-4">
  <div class="card-header font-weight-bold text-primary">
    Edit Status – {{ $siswa->nama_siswa }}
  </div>

  <div class="card-body">
    {{-- HIDDEN jadwal agar ikut di update --}}
    <form action="{{ route('guru.students.update', [
            $siswa->id,
            'jadwal' => $jadwalId,
            'date'   => $date
        ]) }}" method="POST">
      @csrf @method('PUT')
      <input type="hidden" name="jadwal" value="{{ $jadwalId }}">

      <div class="form-group">
        <label>Kelas</label>
        <input type="text" class="form-control"
          value="{{ $siswa->kelas->nama_kelas ?? '-' }}" disabled>
      </div>

      <div class="form-group">
        <label>Status Absen ({{ \Carbon\Carbon::parse($date)->format('d/m/Y') }})</label>
        <select name="status_absen" class="form-control" required>
          <option value="">-- Pilih Status --</option>
          @foreach (['sakit'=>'Sakit','izin'=>'Izin','alpha'=>'Alpha'] as $val=>$lbl)
          <option value="{{ $val }}"
            {{ old('status_absen', $absensi->status_absen) === $val ? 'selected' : '' }}>
            {{ $lbl }}
          </option>
          @endforeach
        </select>
      </div>

      <div class="form-group">
        <label>Keterangan (opsional)</label>
        <textarea name="keterangan" rows="2"
          class="form-control">{{ old('keterangan',$absensi->keterangan) }}</textarea>
      </div>

      <button class="btn btn-primary">Simpan</button>
      <a href="{{ route('guru.students.index', [
            'jadwal' => $jadwalId,
            'date'   => $date
        ]) }}" class="btn btn-secondary">Batal</a>
    </form>
  </div>
</div>
@endsection

@section('script')
<script>
  // tidak ada tabel di halaman ini; script DataTable dihapus
</script>
@endsection