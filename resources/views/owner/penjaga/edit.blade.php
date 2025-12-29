@extends('layouts.app')

@section('content')

<h2>Edit Penjaga</h2>
<p class="subtitle">
    Perbarui data penjaga
</p>

@if($errors->any())
    <div class="card" style="background:#fff1f1;margin-bottom:16px">
        {{ $errors->first() }}
    </div>
@endif

<form method="POST"
      action="{{ route('owner.penjaga.update', $user) }}">
    @csrf
    @method('PUT')

    <div class="card">

        {{-- NAMA --}}
        <label>Nama Penjaga</label>
        <input type="text"
               name="name"
               value="{{ old('name', $user->name) }}"
               required>

        {{-- EMAIL --}}
        <label style="margin-top:12px">Email</label>
        <input type="email"
               name="email"
               value="{{ old('email', $user->email) }}"
               required>

        {{-- CABANG --}}
        <label style="margin-top:12px">Cabang Warung</label>
        <select name="warung_id">
            <option value="">-- Tidak ditugaskan --</option>
            @foreach($warungs as $w)
                <option value="{{ $w->id }}"
                    @selected($user->warung_id == $w->id)>
                    {{ $w->nama_warung }}
                </option>
            @endforeach
        </select>

        <div style="margin-top:16px">
            <button class="btn">Simpan Perubahan</button>
            <a href="{{ route('owner.penjaga.index') }}"
               class="btn secondary">
                Batal
            </a>
        </div>

    </div>
</form>

@endsection
