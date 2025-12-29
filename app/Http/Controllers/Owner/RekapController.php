<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\OmsetHarian;
use App\Models\Warung;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RekapExport;
use Barryvdh\DomPDF\Facade\Pdf;

class RekapController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->get('bulan', now()->month);
        $tahun = $request->get('tahun', now()->year);
        $warungId = $request->get('warung_id');

        $query = OmsetHarian::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun);

        if ($warungId) {
            $query->where('warung_id', $warungId);
        }

        $data = $query->orderBy('tanggal')->get();

        $summary = [
            'omset'   => $data->sum('omset'),
            'profit'  => $data->sum('profit'),
            'owner'   => $data->sum('owner_profit'),
            'penjaga' => $data->sum('penjaga_profit'),
        ];

        $warungs = Warung::all();

        return view('owner.rekap', compact(
            'data',
            'summary',
            'bulan',
            'tahun',
            'warungs',
            'warungId'
        ));
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(
            new RekapExport($request),
            'rekap-bulanan.xlsx'
        );
    }

    public function exportPdf(Request $request)
    {
        $bulan = $request->get('bulan', now()->month);
        $tahun = $request->get('tahun', now()->year);
        $warungId = $request->get('warung_id');

        $query = OmsetHarian::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun);

        if ($warungId) {
            $query->where('warung_id', $warungId);
        }

        $data = $query->orderBy('tanggal')->get();

        $summary = [
            'omset'   => $data->sum('omset'),
            'profit'  => $data->sum('profit'),
            'owner'   => $data->sum('owner_profit'),
            'penjaga' => $data->sum('penjaga_profit'),
        ];

        return Pdf::loadView('exports.rekap_pdf', compact(
            'data',
            'summary',
            'bulan',
            'tahun'
        ))->download('rekap-bulanan.pdf');
    }
}