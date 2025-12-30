<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\OmsetHarian;
use App\Models\Warung;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->bulan ?? now()->month;
        $tahun = $request->tahun ?? now()->year;

        // ======================
        // SUMMARY
        // ======================
        $hariIni = Carbon::today();

        $omsetHariIni = OmsetHarian::whereDate('tanggal', $hariIni)->sum('omset');

        $omsetBulan = OmsetHarian::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->sum('omset');

        $profitBulan = OmsetHarian::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->sum('bagian_owner');

        $jumlahWarung = Warung::count();

        // ======================
        // PROFIT SPLIT
        // ======================
        $profitOwner = OmsetHarian::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->sum('bagian_owner');

        $profitPenjaga = OmsetHarian::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->sum('bagian_penjaga');

        // ======================
        // OMSET PER CABANG
        // ======================
        $omsetPerCabang = OmsetHarian::select(
                'warungs.nama',
                DB::raw('SUM(omset_harians.omset) as total')
            )
            ->join('warungs', 'warungs.id', '=', 'omset_harians.warung_id')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->groupBy('warungs.nama')
            ->get();

        // ======================
        // OMSET HARIAN
        // ======================
        $omsetHarian = OmsetHarian::select(
                'tanggal',
                DB::raw('SUM(omset) as total')
            )
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        // ======================
        // NOTIFIKASI OMSET TURUN
        // ======================
        $avg7Hari = OmsetHarian::whereBetween(
                'tanggal',
                [now()->subDays(7), now()->subDay()]
            )->avg('omset');

        $omsetHariIni = OmsetHarian::whereDate('tanggal', now())->sum('omset');

        $alertOmsetTurun = false;
        $persentaseTurun = 0;

        if ($avg7Hari && $omsetHariIni < ($avg7Hari * 0.7)) {
            $alertOmsetTurun = true;
            $persentaseTurun = round(
                100 - (($omsetHariIni / $avg7Hari) * 100)
            );
        }


        return view('owner.dashboard', [
            // DATA UTAMA
            'bulan' => $bulan,
            'tahun' => $tahun,
            'summary' => [
                'hari_ini' => $omsetHariIni,
                'bulan'    => $omsetBulan,
                'profit'   => $profitBulan,
                'warung'   => $jumlahWarung,
            ],
            'profitSplit' => [
                'owner'   => $profitOwner,
                'penjaga' => $profitPenjaga,
            ],
            'cabangs' => $omsetPerCabang,
            'harian'  => $omsetHarian,

            // NOTIFIKASI
            'alertOmsetTurun' => $alertOmsetTurun,
            'persentaseTurun' => $persentaseTurun,
            'avg7Hari'        => $avg7Hari,
        ]);
    }
}
