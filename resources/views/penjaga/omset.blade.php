@extends('layouts.app')

@section('content')

<style>
    @media (max-width: 768px) {
        .form-grid-2 {
            grid-template-columns: 1fr !important;
        }
    }
</style>

<h2>Input Omset Harian</h2>
<p class="subtitle">
    Masukkan omset harian warung Anda (profit 10% dari omset, dibagi 50:50)
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
@if($errors->any())
    <div class="card" style="
        background:#fff1f1;
        border:1px solid #f3c1c1;
        color:#a94442;
        margin-bottom:16px;
    ">
        {{ $errors->first() }}
    </div>
@endif

{{-- FORM --}}
<form method="POST" action="{{ route('penjaga.omset.store') }}">
    @csrf

    <div class="card">
        <div class="form-grid-2" style="
            display:grid;
            grid-template-columns:repeat(auto-fit, minmax(200px, 1fr));
            gap:20px;
            margin-bottom:20px;
        ">
            {{-- TANGGAL --}}
            <div>
                <label style="
                    display:block;
                    font-size:13px;
                    color:#6e6b7b;
                    margin-bottom:8px;
                    font-weight:500;
                ">Tanggal</label>
                <input
                    type="date"
                    name="tanggal"
                    value="{{ old('tanggal', date('Y-m-d')) }}"
                    required
                    style="
                        width:100%;
                        padding:10px 12px;
                        border-radius:6px;
                        border:1px solid #d8d6de;
                        font-size:14px;
                        color:#6e6b7b;
                        background:#fff;
                    "
                >
            </div>

            {{-- OMSET --}}
            <div>
                <label style="
                    display:block;
                    font-size:13px;
                    color:#6e6b7b;
                    margin-bottom:8px;
                    font-weight:500;
                ">Omset (Rp)</label>
                <input
                    type="number"
                    name="omset"
                    min="0"
                    value="{{ old('omset') }}"
                    placeholder="Contoh: 1500000"
                    required
                    style="
                        width:100%;
                        padding:10px 12px;
                        border-radius:6px;
                        border:1px solid #d8d6de;
                        font-size:14px;
                        color:#6e6b7b;
                        background:#fff;
                    "
                >
            </div>
        </div>

        {{-- INFO BAGI HASIL --}}
        <div style="
            margin-bottom:20px;
            padding:12px 16px;
            background:#f8f8f8;
            border-radius:6px;
            font-size:13px;
            color:#6e6b7b;
            border-left:3px solid #7367f0;
        ">
            <strong style="color:#5e5873;">💡 Catatan:</strong><br>
            Profit akan otomatis dihitung <strong>10% dari omset</strong> dan dibagi <strong>50:50</strong> antara owner dan penjaga.
        </div>

        {{-- SUBMIT --}}
        <div>
            <button class="btn" style="
                padding:10px 24px;
                font-size:14px;
            ">
                💾 Simpan Omset
            </button>
        </div>
    </div>
</form>

@endsection
