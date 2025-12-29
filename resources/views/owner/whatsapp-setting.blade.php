@extends('layouts.app')

@section('content')

<h2>⚙️ Setting WhatsApp Alert</h2>
<p class="subtitle">
    Konfigurasi dan monitoring alert WhatsApp untuk omset turun
</p>

{{-- ALERT SUCCESS --}}
@if(session('success'))
    <div class="card" style="
        background:#e8fff3;
        border:1px solid #c7f0dc;
        color:#1f7a4d;
        margin-bottom:16px;
    ">
        {{ session('success') }}
    </div>
@endif

{{-- ALERT ERROR --}}
@if(session('error'))
    <div class="card" style="
        background:#fff1f1;
        border:1px solid #f3c1c1;
        color:#a94442;
        margin-bottom:16px;
    ">
        {{ session('error') }}
    </div>
@endif

{{-- KONFIGURASI --}}
<div class="card" style="margin-bottom:20px">
    <h3 style="margin:0 0 16px;font-size:16px">📱 Konfigurasi WhatsApp API</h3>
    
    <div style="margin-bottom:12px">
        <div style="font-size:13px;color:#6e6b7b;margin-bottom:4px">API URL:</div>
        <div style="font-weight:600">{{ $apiUrl ?: 'Belum dikonfigurasi' }}</div>
    </div>

    <div style="margin-bottom:16px">
        <div style="font-size:13px;color:#6e6b7b;margin-bottom:4px">Nomor WhatsApp:</div>
        <div style="font-weight:600">{{ $phoneNumber ?: 'Belum dikonfigurasi' }}</div>
    </div>

    <div style="padding:12px;background:#f8f8f8;border-radius:6px;font-size:13px;color:#6e6b7b;margin-bottom:16px">
        <strong>💡 Cara Setting:</strong><br>
        1. Edit file <code>.env</code><br>
        2. Tambahkan konfigurasi berikut:<br>
        <code style="display:block;margin-top:8px;padding:8px;background:#fff;border-radius:4px">
            WHATSAPP_API_URL=http://localhost:3000<br>
            WHATSAPP_API_KEY=your_api_key_here<br>
            WHATSAPP_PHONE_NUMBER=628123456789
        </code>
    </div>

    <div style="display:flex;gap:8px;flex-wrap:wrap">
        <form action="{{ route('owner.whatsapp.test') }}" method="POST" style="display:inline">
            @csrf
            <button class="btn secondary">
                🔌 Test Koneksi
            </button>
        </form>

        <form action="{{ route('owner.whatsapp.test-alert') }}" method="POST" style="display:inline">
            @csrf
            <button class="btn warning">
                📨 Kirim Test Alert
            </button>
        </form>
    </div>
</div>

{{-- RIWAYAT ALERT --}}
<div class="card">
    <h3 style="margin:0 0 16px;font-size:16px">📊 Riwayat Alert (20 Terakhir)</h3>

    {{-- DESKTOP TABLE --}}
    <div class="desktop-only">
        <table class="table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Omset Hari Ini</th>
                    <th>Avg 7 Hari</th>
                    <th>Turun</th>
                    <th>Status WA</th>
                    <th>Waktu Kirim</th>
                </tr>
            </thead>
            <tbody>
                @forelse($alerts as $alert)
                    <tr>
                        <td>{{ $alert->tanggal->format('d/m/Y') }}</td>
                        <td>{{ rupiahShort($alert->omset_hari_ini) }}</td>
                        <td>{{ rupiahShort($alert->avg_7_hari) }}</td>
                        <td>
                            <span style="color:#ea5455;font-weight:600">
                                {{ $alert->persentase_turun }}%
                            </span>
                        </td>
                        <td>
                            @if($alert->whatsapp_sent)
                                <span style="color:#28c76f;font-weight:600">✓ Terkirim</span>
                            @else
                                <span style="color:#ea5455;font-weight:600">✗ Gagal</span>
                            @endif
                        </td>
                        <td>
                            {{ $alert->sent_at ? $alert->sent_at->format('d/m/Y H:i') : '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" align="center">Belum ada riwayat alert</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- MOBILE CARD MODE --}}
    <div class="mobile-only">
        @forelse($alerts as $alert)
            <div class="card" style="margin-bottom:12px;background:#f9f9f9">
                <div style="font-weight:600;margin-bottom:8px">
                    📅 {{ $alert->tanggal->format('d/m/Y') }}
                </div>
                <div style="font-size:13px;margin-bottom:4px">
                    Omset: <strong>{{ rupiahShort($alert->omset_hari_ini) }}</strong>
                </div>
                <div style="font-size:13px;margin-bottom:4px">
                    Avg 7 Hari: <strong>{{ rupiahShort($alert->avg_7_hari) }}</strong>
                </div>
                <div style="font-size:13px;margin-bottom:4px">
                    Turun: <strong style="color:#ea5455">{{ $alert->persentase_turun }}%</strong>
                </div>
                <div style="font-size:13px">
                    Status: 
                    @if($alert->whatsapp_sent)
                        <strong style="color:#28c76f">✓ Terkirim</strong>
                        ({{ $alert->sent_at->format('H:i') }})
                    @else
                        <strong style="color:#ea5455">✗ Gagal</strong>
                    @endif
                </div>
            </div>
        @empty
            <div class="card">Belum ada riwayat alert</div>
        @endforelse
    </div>
</div>

@endsection

