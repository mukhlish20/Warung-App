@extends('layouts.app')

@section('content')

<h2>Tambah Penjaga</h2>
<p class="subtitle">Buat akun penjaga baru</p>

@if($errors->any())
    <div class="card" style="background:#fff1f1;margin-bottom:16px">
        {{ $errors->first() }}
    </div>
@endif

<form method="POST" action="{{ route('owner.penjaga.store') }}">
    @csrf

    <div class="card">

        <label>Nama Penjaga</label>
        <input type="text" name="name" required>

        <label style="margin-top:12px">Email</label>
        <input type="email" name="email" required>

        <label style="margin-top:12px">Password</label>
        <input type="password" name="password" required>

        <label style="margin-top:12px">Cabang Warung</label>
        <select name="warung_id" required>
            @foreach($warungs as $w)
                <option value="{{ $w->id }}">
                    {{ $w->nama }}
                </option>
            @endforeach
        </select>

        <div style="margin-top:16px">
            <button class="btn">Simpan</button>
            <a href="{{ route('owner.penjaga.index') }}"
               class="btn secondary">
                Batal
            </a>
        </div>

    </div>
</form>

@endsection
