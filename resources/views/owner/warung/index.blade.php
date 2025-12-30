@extends('layouts.app')

@section('content')

<h2>Cabang Warung</h2>
<p class="subtitle">Kelola semua cabang warung</p>

@if(session('success'))
    <div class="card" style="background:#e8fff3;margin-bottom:16px">
        {{ session('success') }}
    </div>
@endif

<a href="{{ route('owner.warung.create') }}"
   class="btn"
   style="margin-bottom:16px;display:inline-block">
    + Tambah Cabang
</a>

{{-- DESKTOP TABLE --}}
<div class="card desktop-only">
    <table class="table">
        <thead>
            <tr>
                <th width="50">#</th>
                <th>Nama Warung</th>
                <th width="260">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($warungs as $index => $warung)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <strong>{{ $warung->nama }}</strong><br>
                        <small style="color:#999">
                            {{ $warung->alamat ?? '-' }}
                        </small>
                    </td>
                    <td style="white-space:nowrap">
                        {{-- EDIT --}}
                        <a href="{{ route('owner.warung.edit', $warung->id) }}"
                           class="btn secondary"
                           style="margin-right:8px">
                            Edit
                        </a>

                        {{-- HAPUS --}}
                        <form action="{{ route('owner.warung.destroy', $warung->id) }}"
                              method="POST"
                              style="display:inline"
                              onsubmit="return confirm('Yakin ingin menghapus cabang ini?')">
                            @csrf
                            @method('DELETE')

                            <button class="btn danger">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" align="center">
                        Belum ada cabang warung
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- MOBILE CARD MODE --}}
<div class="mobile-only">
    @forelse($warungs as $index => $warung)
        <div class="card" style="margin-bottom:12px">
            <div style="margin-bottom:12px">
                <div style="font-weight:600;font-size:16px;margin-bottom:4px">
                    {{ $warung->nama }}
                </div>
                <div style="color:#999;font-size:13px">
                    {{ $warung->alamat ?? '-' }}
                </div>
            </div>

            <div style="display:flex;gap:8px">
                <a href="{{ route('owner.warung.edit', $warung->id) }}"
                   class="btn secondary"
                   style="flex:1;text-align:center;text-decoration:none">
                    ✏️ Edit
                </a>

                <form action="{{ route('owner.warung.destroy', $warung->id) }}"
                      method="POST"
                      style="flex:1"
                      onsubmit="return confirm('Yakin ingin menghapus cabang ini?')">
                    @csrf
                    @method('DELETE')

                    <button class="btn danger" style="width:100%">
                        🗑️ Hapus
                    </button>
                </form>
            </div>
        </div>
    @empty
        <div class="card">Belum ada cabang warung</div>
    @endforelse
</div>

@endsection
