@extends('layouts.app')

@section('content')

<h2>Tambah Cabang Warung</h2>
<p class="subtitle">Masukkan nama cabang baru</p>

@if($errors->any())
    <div class="card" style="background:#fff1f1;margin-bottom:16px">
        {{ $errors->first() }}
    </div>
@endif

<form method="POST" action="{{ route('owner.warung.store') }}">
    @csrf

    <div class="card">
        <div class="card-title">Nama Warung</div>
        <input
            type="text"
            name="nama"
            required
            placeholder="Contoh: Warung Cabang Sudirman"
            style="width:100%;padding:10px;border-radius:8px;border:1px solid #ddd"
        >

        <div style="margin-top:16px">
            <button class="btn">Simpan</button>
            <a href="{{ route('owner.warung.index') }}" class="btn secondary">
                Batal
            </a>
        </div>
    </div>
</form>

@endsection
