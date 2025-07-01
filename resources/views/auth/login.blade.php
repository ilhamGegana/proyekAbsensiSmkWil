@extends('layouts.authMaster')

@section('title', 'Login')
@section('heading', 'Welcome Back!')

@section('form')
<form class="user" method="POST" action="{{ route('login') }}">
    @csrf
    <div class="form-group">
        <input type="text" name="username" class="form-control form-control-user"
            placeholder="Username" required autofocus>
    </div>
    <div class="form-group">
        <input type="password" name="password" class="form-control form-control-user"
            placeholder="Password" required>
    </div>
    <div class="form-group">
        <div class="custom-control custom-checkbox small">
            <input type="checkbox" class="custom-control-input" id="remember" name="remember">
            <label class="custom-control-label" for="remember">Remember Me</label>
        </div>
    </div>
    <button type="submit" class="btn btn-green btn-user btn-block">Login</button>

    @if ($errors->any())
    <div class="alert alert-danger mt-3">{{ $errors->first() }}</div>
    @endif
</form>
@endsection

@section('extra-links')
<hr>
<div class="text-center">
    <a class="small text-green-custom" href="{{ route('register') }}">Buat Akun!</a>
</div>
@endsection