@extends('admin.layouts.master')

@section('title', 'Threshold Setting')
@section('content')
<div class="container">
    <h1>Pengaturan Threshold Tanda Tangan</h1>

    <form method="POST" action="{{ route('admin.signature.update') }}">
        @csrf
        <div class="form-group">
            <label for="threshold">Threshold (%)</label>
            <input type="number" name="threshold" id="threshold" class="form-control"
                   value="{{ old('threshold', $setting->threshold) }}" min="1" max="100" required>
        </div>
        <button type="submit" class="btn btn-primary mt-2">Simpan</button>
    </form>
</div>
@endsection
