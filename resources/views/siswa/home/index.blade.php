@extends('siswa.layouts.master')

@section('title', 'Dashboard Siswa')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header">
                    Selamat datang di halaman siswa.
                </div>
                <div class="card-body">
                    {{-- Tombol generate kode undangan --}}
                    <button id="genBtn" type="button" class="btn btn-green btn-sm">
                        Generate Kode Undangan
                    </button>
                    {{-- Tempat menampilkan kode --}}
                    <span id="codeBox" class="badge badge-success ml-2 d-none"></span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(function() {
        $('#genBtn').on('click', function() {
            $.post("{{ route('siswa.generate-code') }}", {
                _token: "{{ csrf_token() }}"
            }, function(res) {
                $('#codeBox')
                    .text(`${res.code} (exp: ${res.expires})`)
                    .removeClass('d-none');
            }).fail(() => {
                alert('Gagal membuat kode, coba lagi atau hubungi admin.');
            });
        });
    });
</script>
@endpush