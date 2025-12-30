@extends('layouts.app')

@section('content')

<h2>Dashboard Owner</h2>
@if($alertOmsetTurun)
    <div class="card" style="
        background:#fff1f1;
        border-left:6px solid #ea5455;
        margin-bottom:20px
    ">
        <strong>⚠️ Omset Turun Signifikan</strong>
        <p style="margin:6px 0 0;font-size:14px">
            Omset hari ini turun sekitar
            <strong>{{ $persentaseTurun }}%</strong>
            dibanding rata-rata 7 hari terakhir
            ({{ rupiahShort($avg7Hari) }}).
        </p>
    </div>
@endif

<p class="subtitle">Ringkasan omset dan pembagian profit</p>

{{-- FILTER --}}
<form method="GET" class="card" style="margin-bottom:20px">
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(140px,1fr));gap:12px;align-items:end">
        <div>
            <label>Bulan</label>
            <select name="bulan">
                @for($i=1;$i<=12;$i++)
                    <option value="{{ $i }}" @selected($bulan==$i)>
                        {{ date('F', mktime(0,0,0,$i,1)) }}
                    </option>
                @endfor
            </select>
        </div>

        <div>
            <label>Tahun</label>
            <select name="tahun">
                @for($y=now()->year;$y>=now()->year-5;$y--)
                    <option value="{{ $y }}" @selected($tahun==$y)>
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

{{-- SUMMARY --}}
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:16px;margin-bottom:24px">

    <div class="card">
        <div class="card-title">Omset Hari Ini</div>
        <div class="card-value">{{ rupiahShort($summary['hari_ini']) }}</div>
    </div>

    <div class="card">
        <div class="card-title">Omset Bulan Ini</div>
        <div class="card-value">{{ rupiahShort($summary['bulan']) }}</div>
    </div>

    <div class="card">
        <div class="card-title">Total Profit</div>
        <div class="card-value">{{ rupiahShort($summary['profit']) }}</div>
    </div>

    <div class="card">
        <div class="card-title">Jumlah Cabang</div>
        <div class="card-value">{{ $summary['warung'] }}</div>
    </div>

</div>

{{-- PROFIT SPLIT (ANGKA) --}}
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:16px;margin-bottom:24px">

    <div class="card" style="background:#f1f8ff">
        <div class="card-title">Bagian Owner</div>
        <div class="card-value">{{ rupiahShort($profitSplit['owner']) }}</div>
    </div>

    <div class="card" style="background:#fef7ec">
        <div class="card-title">Bagian Penjaga</div>
        <div class="card-value">{{ rupiahShort($profitSplit['penjaga']) }}</div>
    </div>

</div>

{{-- GRAFIK - RESPONSIVE --}}
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:16px;margin-bottom:24px">

    <div class="card">
        <h3>Omset per Cabang</h3>
        <canvas id="chartCabang" height="200"></canvas>
    </div>

    <div class="card">
        <h3>Omset Harian</h3>
        <canvas id="chartHarian" height="200"></canvas>
    </div>

    <div class="card">
        <h3>Profit Split</h3>
        <canvas id="chartProfit" height="200"></canvas>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // =====================
    // WARNA THEME
    // =====================
    const colors = {
        primary: '#7367f0',
        success: '#28c76f',
        warning: '#ff9f43',
        softPrimary: '#e9e7fd',
        softWarning: '#fef7ec'
    };

    // =====================
    // RUPIAH SHORT
    // =====================
    function rupiahShortJS(value) {
        if (value >= 1_000_000_000) return 'Rp ' + (value / 1_000_000_000).toFixed(1) + ' M';
        if (value >= 1_000_000) return 'Rp ' + (value / 1_000_000).toFixed(1) + ' jt';
        if (value >= 1_000) return 'Rp ' + (value / 1_000).toFixed(1) + ' rb';
        return 'Rp ' + value;
    }

    const tooltipConfig = {
        callbacks: {
            label: ctx => rupiahShortJS(ctx.raw)
        }
    };

    // =====================
    // OMSET PER CABANG
    // =====================
    new Chart(chartCabang, {
        type: 'bar',
        data: {
            labels: {!! json_encode($cabangs->pluck('nama')) !!},
            datasets: [{
                label: 'Omset',
                data: {!! json_encode($cabangs->pluck('total')) !!},
                backgroundColor: colors.softPrimary,
                borderColor: colors.primary,
                borderWidth: 2,
                borderRadius: 8
            }]
        },
        options: {
            plugins: { tooltip: tooltipConfig }
        }
    });

    // =====================
    // OMSET HARIAN
    // =====================
    new Chart(chartHarian, {
        type: 'line',
        data: {
            labels: {!! json_encode($harian->pluck('tanggal')) !!},
            datasets: [{
                label: 'Omset',
                data: {!! json_encode($harian->pluck('total')) !!},
                borderColor: colors.primary,
                backgroundColor: 'rgba(115,103,240,0.15)',
                fill: true,
                tension: 0.4,
                pointRadius: 3
            }]
        },
        options: {
            plugins: { tooltip: tooltipConfig }
        }
    });

    // =====================
    // PROFIT SPLIT
    // =====================
    new Chart(chartProfit, {
        type: 'doughnut',
        data: {
            labels: ['Owner', 'Penjaga'],
            datasets: [{
                data: [
                    {{ $profitSplit['owner'] }},
                    {{ $profitSplit['penjaga'] }}
                ],
                backgroundColor: [
                    colors.primary,
                    colors.warning
                ]
            }]
        },
        options: {
            plugins: { tooltip: tooltipConfig }
        }
    });
</script>

@endsection
