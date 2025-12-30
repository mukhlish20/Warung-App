@extends('layouts.app')

@section('content')

<h2>Dashboard Penjaga</h2>
<p class="subtitle">
    Rekap omset dan profit bulanan warung Anda
</p>

{{-- FILTER BULAN & TAHUN --}}
<form method="GET" class="card" style="margin-bottom:20px">
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(140px,1fr));gap:12px;align-items:end">
        <div>
            <label>Bulan</label>
            <select name="bulan">
                @for($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}" @selected($bulan == $i)>
                        {{ date('F', mktime(0,0,0,$i,1)) }}
                    </option>
                @endfor
            </select>
        </div>

        <div>
            <label>Tahun</label>
            <select name="tahun">
                @for($y = now()->year; $y >= now()->year - 5; $y--)
                    <option value="{{ $y }}" @selected($tahun == $y)>
                        {{ $y }}
                    </option>
                @endfor
            </select>
        </div>

        <div>
            <button class="btn">📊 Tampilkan</button>
        </div>
    </div>
</form>

{{-- SUMMARY CARDS --}}
<div style="
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:16px;
    margin-bottom:24px;
">
    <div class="card">
        <div class="card-title">Total Omset</div>
        <div class="card-value">
            {{ rupiahShort($summary['omset']) }}
        </div>
    </div>

    <div class="card">
        <div class="card-title">Total Profit</div>
        <div class="card-value">
            {{ rupiahShort($summary['profit']) }}
        </div>
    </div>

    <div class="card">
        <div class="card-title">Bagian Anda</div>
        <div class="card-value">
            {{ rupiahShort($summary['penjaga']) }}
        </div>
    </div>
</div>

{{-- DESKTOP TABLE --}}
<div class="card desktop-only">
    <table class="table">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Omset</th>
                <th>Profit</th>
                <th>Bagian Anda</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $row)
                <tr>
                    <td>{{ $row->tanggal }}</td>
                    <td>{{ rupiahShort($row->omset) }}</td>
                    <td>{{ rupiahShort($row->bagian_owner) }}</td>
                    <td>{{ rupiahShort($row->bagian_penjaga) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" align="center">Belum ada data</td>
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
            <div>Profit: <strong>{{ rupiahShort($row->bagian_owner) }}</strong></div>
            <div>Bagian Anda: <strong>{{ rupiahShort($row->bagian_penjaga) }}</strong></div>
        </div>
    @empty
        <div class="card">Belum ada data</div>
    @endforelse
</div>

@endsection
