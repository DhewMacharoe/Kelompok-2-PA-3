@extends('layouts.public')

@section('title', 'Set Username - Arga Barbershop')

@section('content')
<div style="max-width: 400px; margin: 50px auto; padding: 20px; background: var(--bg); border: 1px solid var(--border-light); border-radius: var(--radius-md);">
    <h2 style="text-align: center; margin-bottom: 20px;">Pilih Username</h2>
    <p style="text-align: center; color: var(--text-secondary); margin-bottom: 20px;">Silakan pilih username unik untuk akun Anda.</p>

    @if(session('error'))
        <div style="color: red; margin-bottom: 10px;">{{ session('error') }}</div>
    @endif

    <form action="{{ route('set.username.post') }}" method="POST">
        @csrf
        <div style="margin-bottom: 15px;">
            <label for="username" style="display: block; margin-bottom: 5px;">Username:</label>
            <input type="text" id="username" name="username" required style="width: 100%; padding: 10px; border: 1px solid var(--border-light); border-radius: var(--radius-sm);" placeholder="Masukkan username">
        </div>
        <button type="submit" style="width: 100%; padding: 12px; background: #28a745; color: white; border: none; border-radius: var(--radius-sm); cursor: pointer; font-size: 16px; font-weight: bold;">Simpan Username</button>
    </form>
</div>
@endsection