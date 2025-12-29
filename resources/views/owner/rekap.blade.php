@extends('layouts.app')

@section('content')

<h2>Rekap Bulanan</h2>
<p class="subtitle">
    Rekap omset dan profit seluruh cabang
</p>

{{-- FILTER --}}
<form method="GET" class="card" style="margin-bottom:20px">
    <div style="
        display:grid;
        grid-template-columns:repeat(auto-fit,minmax(160px,1fr));
        gap:12px;
        align-items:end;
    ">
        {{-- BULAN --}}
        <div>
            <div class="card-title">Bulan</div>
            <select name="bulan">
                @for($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}" @selected($bulan == $i)>
                        {{ date('F', mktime(0,0,0,$i,1)) }}
                    </option>
                @endfor
            </select>
        </div>

        {{-- TAHUN --}}
        <div>
            <div class="card-title">Tahun</div>
            <select name="tahun">
                @for($y = now()->year; $y >= now()->year - 5; $y--)
                    <option value="{{ $y }}" @selected($tahun == $y)>
                        {{ $y }}
                    </option>
                @endfor
            </select>
        </div>

        {{-- WARUNG --}}
        <div>
            <div class="card-title">Warung</div>
            <select name="warung_id">
                <option value="">Semua Warung</option>
                @foreach($warungs as $w)
                    <option value="{{ $w->id }}" @selected($warungId == $w->id)>
                        {{ $w->nama_warung }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- BUTTON --}}
        <div>
            <button class="btn">Tampilkan</button>
        </div>
    </div>
</form>

{{-- SUMMARY --}}
<div style="
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:16px;
    margin-bottom:24px;
">
    <div class="card">
        <div class="card-title">Total Omset</div>
        <div class="card-value">{{ rupiahShort($summary['omset']) }}</div>
    </div>

    <div class="card">
        <div class="card-title">Total Profit</div>
        <div class="card-value">{{ rupiahShort($summary['profit']) }}</div>
    </div>

    <div class="card">
        <div class="card-title">Bagian Owner</div>
        <div class="card-value">{{ rupiahShort($summary['owner']) }}</div>
    </div>

    <div class="card">
        <div class="card-title">Bagian Penjaga</div>
        <div class="card-value">{{ rupiahShort($summary['penjaga']) }}</div>
    </div>
</div>

{{-- EXPORT BUTTON --}}
<div style="margin-bottom:16px;display:flex;gap:8px;flex-wrap:wrap">
    <a class="btn secondary" href="{{ route('owner.rekap.excel', request()->query()) }}" style="text-decoration:none">
        📊 Export Excel
    </a>
    <a class="btn secondary" href="{{ route('owner.rekap.pdf', request()->query()) }}" style="text-decoration:none">
        📄 Export PDF
    </a>
</div>

{{-- DESKTOP TABLE --}}
<div class="card desktop-only">
    <table class="table">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Omset</th>
                <th>Profit</th>
                <th>Owner</th>
                <th>Penjaga</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $row)
                <tr>
                    <td>{{ $row->tanggal }}</td>
                    <td>{{ rupiahShort($row->omset) }}</td>
                    <td>{{ rupiahShort($row->profit) }}</td>
                    <td>{{ rupiahShort($row->owner_profit) }}</td>
                    <td>{{ rupiahShort($row->penjaga_profit) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" align="center">Belum ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- MOBILE CARD MODE --}}
<div class="mobile-only">
    @forelse($data as $row)
        <div class="card" style="margin-bottom:12px">
            <div class="card-title">{{ $row->tanggal }}</div>
            <div>Omset: <strong>{{ rupiahShort($row->omset) }}</strong></div>
            <div>Profit: <strong>{{ rupiahShort($row->profit) }}</strong></div>
            <div>Owner: <strong>{{ rupiahShort($row->owner_profit) }}</strong></div>
            <div>Penjaga: <strong>{{ rupiahShort($row->penjaga_profit) }}</strong></div>
        </div>
    @empty
        <div class="card">Belum ada data</div>
    @endforelse
</div>

@endsection
