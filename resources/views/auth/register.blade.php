@extends('layouts.authMaster')

@section('title', 'Register')
@section('heading', 'Create an Account!')

@section('form')
<form method="POST" action="{{ route('register') }}" id="registerForm">
    @csrf
    {{-- Role selector --}}
    <div class="form-group">
        <select name="role" id="roleSelect" class="form-control form-control-user" required>
            <option disabled selected>-- Pilih Peran --</option>
            <option value="siswa">Siswa</option>
            <option value="guru">Guru</option>
            <option value="walimurid">Wali Murid</option>
        </select>
    </div>

    {{-- Identifier (telepon, NIS/NIP, atau kode) --}}
    <div class="form-group">
        <input type="text" id="identifierInput" name="identifier" class="form-control form-control-user" placeholder="Nomor Induk" required>
        <small id="identifierHelp" class="form-text text-muted mt-1 d-none">
            *Jika nomor telepon wali tidak terdaftar, masukkan <strong>kode undangan</strong> yang Anda dapatkan dari akun siswa.*
        </small>
    </div>

    {{-- Username --}}
    <div class="form-group">
        <input type="text" name="username" class="form-control form-control-user" placeholder="Username" required>
    </div>

    {{-- Password & Confirmation --}}
    <div class="form-group row">
        <div class="col-sm-6 mb-3 mb-sm-0">
            <input type="password" name="password" class="form-control form-control-user" placeholder="Password" required>
        </div>
        <div class="col-sm-6">
            <input type="password" name="password_confirmation" class="form-control form-control-user" placeholder="Repeat Password" required>
        </div>
    </div>

    <button type="submit" class="btn btn-green btn-user btn-block">Register Account</button>

    @if ($errors->any())
        <div class="alert alert-danger mt-3">{{ $errors->first() }}</div>
    @endif
</form>
@endsection

@section('extra-links')
<hr>
<div class="text-center">
    <a class="small text-green-custom" href="{{ route('login') }}">Already have an account? Login!</a>
</div>
@endsection

@push('scripts')
<script>
$(function () {
    const $role     = $('#roleSelect');
    const $idInput  = $('#identifierInput');
    const $helpText = $('#identifierHelp');

    const placeholders = {
        siswa: 'Masukkan NIS (Nomor Induk Siswa)',
        guru:  'Masukkan NIP atau NUPTK',
        walimurid: 'Masukkan Nomor Telepon Wali / Kode Undangan',
    };

    $role.on('change', function () {
        const key = this.value;
        $idInput.attr('placeholder', placeholders[key] || 'Nomor Induk');
        if (key === 'walimurid') {
            $helpText.removeClass('d-none');
        } else {
            $helpText.addClass('d-none');
        }
    });
});
</script>
@endpush
