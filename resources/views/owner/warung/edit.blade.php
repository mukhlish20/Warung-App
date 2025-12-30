@extends('layouts.app')

@section('content')

<h2>Edit Profil Warung</h2>
<p class="subtitle">Perbarui informasi cabang warung</p>

<div class="card" style="max-width:600px">

    <form method="POST"
          action="{{ route('owner.warung.update', $warung->id) }}">
        @csrf
        @method('PUT')

        <div style="margin-bottom:14px">
            <label>Nama Warung</label>
            <input type="text"
                   name="nama"
                   value="{{ old('nama', $warung->nama) }}"
                   required
                   style="width:100%">
        </div>

        <div style="margin-bottom:14px">
            <label>Alamat</label>
            <input type="text"
                   name="alamat"
                   value="{{ old('alamat', $warung->alamat) }}"
                   style="width:100%">
        </div>

        <div style="margin-bottom:14px">
            <label>No. HP</label>
            <input type="text"
                   name="no_hp"
                   value="{{ old('no_hp', $warung->no_hp) }}"
                   style="width:100%">
        </div>

        <div style="margin-bottom:14px">
            <label>Catatan</label>
            <textarea name="catatan"
                      rows="3"
                      style="width:100%">{{ old('catatan', $warung->catatan) }}</textarea>
        </div>

        <div style="margin-top:20px">
            <button class="btn">Simpan Perubahan</button>
            <a href="{{ route('owner.warung.index') }}"
               class="btn secondary">Batal</a>
        </div>

    </form>

</div>

@endsection
