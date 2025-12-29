@extends('layouts.app')

@section('content')

<h2>Reset Password Penjaga</h2>
<p class="subtitle">
    {{ $user->name }} ({{ $user->email }})
</p>

@if($errors->any())
    <div class="card" style="background:#fff1f1;margin-bottom:16px">
        {{ $errors->first() }}
    </div>
@endif

<form method="POST"
      action="{{ route('owner.penjaga.reset', $user) }}">
    @csrf
    @method('PUT')

    <div class="card">

        <label>Password Baru</label>
        <input type="password"
               name="password"
               required
               minlength="8">

        <label style="margin-top:12px">Konfirmasi Password</label>
        <input type="password"
               name="password_confirmation"
               required
               minlength="8">

        <div style="margin-top:16px">
            <button class="btn danger">
                Reset Password
            </button>

            <a href="{{ route('owner.penjaga.index') }}"
               class="btn secondary">
                Batal
            </a>
        </div>

    </div>
</form>

@endsection
