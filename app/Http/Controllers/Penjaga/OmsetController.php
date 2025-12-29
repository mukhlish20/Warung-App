<?php

namespace App\Http\Controllers\Penjaga;

use App\Http\Controllers\Controller;
use App\Models\OmsetHarian;
use App\Events\OmsetTurunDetected;
use Illuminate\Http\Request;
use Carbon\Carbon;

class OmsetController extends Controller
{
    public function index()
    {
        return view('penjaga.omset');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'omset'   => 'required|numeric|min:0',
        ]);

        $user = auth()->user();

        // Hitung profit otomatis 10% dari omset, dibagi 50:50
        $omset = $request->omset;
        $profit = $omset * 0.1; // Profit = 10% dari omset
        $ownerProfit = $profit * 0.5; // 50% dari profit untuk owner
        $penjagaProfit = $profit * 0.5; // 50% dari profit untuk penjaga

        OmsetHarian::updateOrCreate(
            [
                'warung_id' => $user->warung_id,
                'tanggal'  => $request->tanggal,
            ],
            [
                'omset'          => $omset,
                'profit'         => $profit,
                'owner_profit'   => $ownerProfit,
                'penjaga_profit' => $penjagaProfit,
            ]
        );

        // Cek apakah omset turun signifikan (hanya untuk hari ini)
        if (Carbon::parse($request->tanggal)->isToday()) {
            $this->checkOmsetTurun($omset);
        }

        return back()->with('success', 'Omset berhasil disimpan (Profit 10% dibagi 50:50)');
    }

    /**
     * Cek apakah omset turun signifikan
     */
    protected function checkOmsetTurun(float $omsetHariIni): void
    {
        // Hitung rata-rata omset 7 hari terakhir (tidak termasuk hari ini)
        $avg7Hari = OmsetHarian::whereBetween(
            'tanggal',
            [now()->subDays(7), now()->subDay()]
        )->avg('omset');

        // Jika tidak ada data 7 hari terakhir, skip
        if (!$avg7Hari || $avg7Hari == 0) {
            return;
        }

        // Cek apakah turun lebih dari 30% (threshold)
        $threshold = 0.7; // 70% dari rata-rata

        if ($omsetHariIni < ($avg7Hari * $threshold)) {
            $persentaseTurun = round(100 - (($omsetHariIni / $avg7Hari) * 100));

            // Trigger event untuk kirim WhatsApp
            event(new OmsetTurunDetected(
                $omsetHariIni,
                $avg7Hari,
                $persentaseTurun
            ));
        }
    }
}