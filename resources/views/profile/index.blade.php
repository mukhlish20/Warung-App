@extends('layouts.app')

@section('content')

<h2>Akun Saya</h2>
<p class="subtitle">Kelola profil dan foto akun Anda</p>

@if(session('success'))
    <div class="card" style="background:#e8fff3;margin-bottom:16px">
        {{ session('success') }}
    </div>
@endif

<div class="card" style="max-width:520px">

    <form method="POST"
          action="{{ route('profile.update') }}"
          enctype="multipart/form-data">
        @csrf

        {{-- AVATAR PREVIEW --}}
        <div style="margin-bottom:20px;text-align:center">
            @if($user->avatar)
                <img src="{{ asset('storage/'.$user->avatar) }}"
                     style="width:96px;height:96px;border-radius:50%;object-fit:cover">
            @else
                <div style="
                    width:96px;
                    height:96px;
                    border-radius:50%;
                    background:#e9e7fd;
                    display:flex;
                    align-items:center;
                    justify-content:center;
                    font-size:32px;
                    color:#7367f0;
                    margin:auto;
                ">
                    {{ strtoupper(substr($user->name,0,1)) }}
                </div>
            @endif
        </div>

        {{-- FILE INPUT --}}
        <div style="margin-bottom:14px">
            <label>Foto Profil</label>
            <input type="file" name="avatar" accept="image/*">
            @error('avatar')
                <small style="color:red">{{ $message }}</small>
            @enderror
        </div>

        <div style="margin-bottom:14px">
            <label>Nama</label>
            <input type="text"
                   name="name"
                   value="{{ old('name', $user->name) }}"
                   required
                   style="width:100%">
        </div>

        <div style="margin-bottom:14px">
            <label>Email</label>
            <input type="email"
                   name="email"
                   value="{{ old('email', $user->email) }}"
                   required
                   style="width:100%">
        </div>

        <div style="margin-top:20px">
            <button class="btn">Simpan Perubahan</button>
        </div>
    </form>

</div>

@endsection
