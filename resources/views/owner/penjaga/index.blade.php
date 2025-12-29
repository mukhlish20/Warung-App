@extends('layouts.app')

@section('content')

<h2>Penjaga Warung</h2>
<p class="subtitle">Kelola penjaga dan cabang warung</p>

@if(session('success'))
    <div class="card" style="background:#e8fff3;margin-bottom:16px">
        {{ session('success') }}
    </div>
@endif

{{-- TOMBOL TAMBAH --}}
<a href="{{ route('owner.penjaga.create') }}"
   class="btn"
   style="margin-bottom:16px;display:inline-block">
    + Tambah Penjaga
</a>

{{-- DESKTOP TABLE --}}
<div class="card desktop-only">
    <table class="table">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Cabang</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>

            @forelse($penjagas as $p)
                <tr>
                    <td>{{ $p->name }}</td>
                    <td>{{ $p->email }}</td>

                    {{-- CABANG --}}
                    <td>
                        {{ $p->warung?->nama_warung ?? '-' }}
                    </td>

                    {{-- STATUS --}}
                    <td>
                        @if($p->is_active)
                            <span style="color:green;font-weight:600">
                                ✓ Aktif
                            </span>
                        @else
                            <span style="color:red;font-weight:600">
                                ✗ Nonaktif
                            </span>
                        @endif
                    </td>

                    {{-- AKSI --}}
                    <td style="white-space:nowrap">

                        {{-- EDIT --}}
                        <a href="{{ route('owner.penjaga.edit', $p) }}"
                           class="btn secondary"
                           style="margin-right:4px">
                            Edit
                        </a>

                        {{-- RESET PASSWORD --}}
                        <a href="{{ route('owner.penjaga.reset.form', $p) }}"
                           class="btn warning"
                           style="margin-right:4px">
                            Reset
                        </a>

                        {{-- TOGGLE AKTIF --}}
                        <form action="{{ route('owner.penjaga.toggle', $p) }}"
                              method="POST"
                              style="display:inline;margin-right:4px"
                              onsubmit="return confirm('Ubah status akun penjaga?')">
                            @csrf
                            @method('PUT')

                            <button class="btn {{ $p->is_active ? 'danger' : 'secondary' }}">
                                {{ $p->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                            </button>
                        </form>

                        {{-- LEPAS CABANG --}}
                        @if($p->warung_id)
                            <form action="{{ route('owner.penjaga.unassign', $p) }}"
                                  method="POST"
                                  style="display:inline"
                                  onsubmit="return confirm('Lepas penjaga dari cabang?')">
                                @csrf
                                @method('DELETE')

                                <button class="btn danger">
                                    Lepas
                                </button>
                            </form>
                        @endif

                    </td>
                </tr>

            @empty
                <tr>
                    <td colspan="5" align="center">
                        Belum ada penjaga
                    </td>
                </tr>
            @endforelse

        </tbody>
    </table>
</div>

{{-- MOBILE CARD MODE --}}
<div class="mobile-only">
    @forelse($penjagas as $p)
        <div class="card" style="margin-bottom:12px">
            <div style="margin-bottom:12px">
                <div style="font-weight:600;font-size:16px;margin-bottom:4px">
                    {{ $p->name }}
                </div>
                <div style="color:#666;font-size:13px;margin-bottom:4px">
                    📧 {{ $p->email }}
                </div>
                <div style="color:#666;font-size:13px;margin-bottom:4px">
                    🏪 {{ $p->warung?->nama_warung ?? 'Belum ditugaskan' }}
                </div>
                <div style="font-size:13px">
                    @if($p->is_active)
                        <span style="color:green;font-weight:600">
                            ✓ Aktif
                        </span>
                    @else
                        <span style="color:red;font-weight:600">
                            ✗ Nonaktif
                        </span>
                    @endif
                </div>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-bottom:8px">
                <a href="{{ route('owner.penjaga.edit', $p) }}"
                   class="btn secondary"
                   style="text-align:center;text-decoration:none">
                    ✏️ Edit
                </a>

                <a href="{{ route('owner.penjaga.reset.form', $p) }}"
                   class="btn warning"
                   style="text-align:center;text-decoration:none">
                    🔑 Reset
                </a>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px">
                <form action="{{ route('owner.penjaga.toggle', $p) }}"
                      method="POST"
                      onsubmit="return confirm('Ubah status akun penjaga?')">
                    @csrf
                    @method('PUT')

                    <button class="btn {{ $p->is_active ? 'danger' : 'secondary' }}">
                        {{ $p->is_active ? '🚫 Nonaktifkan' : '✓ Aktifkan' }}
                    </button>
                </form>

                @if($p->warung_id)
                    <form action="{{ route('owner.penjaga.unassign', $p) }}"
                          method="POST"
                          onsubmit="return confirm('Lepas penjaga dari cabang?')">
                        @csrf
                        @method('DELETE')

                        <button class="btn danger">
                            🔓 Lepas
                        </button>
                    </form>
                @endif
            </div>
        </div>
    @empty
        <div class="card">Belum ada penjaga</div>
    @endforelse
</div>

@endsection
