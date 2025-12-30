<?php

namespace App\Http\Controllers\Penjaga;

use App\Http\Controllers\Controller;
use App\Models\OmsetHarian;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->get('bulan', now()->month);
        $tahun = $request->get('tahun', now()->year);

        $query = OmsetHarian::where('warung_id', auth()->user()->warung_id)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun);

        $data = $query->orderBy('tanggal')->get();

        $summary = [
            'omset'   => $data->sum('omset'),
            'profit'  => $data->sum('owner_profit'),
            'penjaga' => $data->sum('penjaga_profit'),
        ];

        return view('penjaga.dashboard', compact(
            'data',
            'summary',
            'bulan',
            'tahun'
        ));
    }
}
