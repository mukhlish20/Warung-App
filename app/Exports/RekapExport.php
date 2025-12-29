<?php

namespace App\Exports;

use App\Models\OmsetHarian;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class RekapExport implements FromView
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $bulan = $this->request->bulan;
        $tahun = $this->request->tahun;
        $warungId = $this->request->warung_id;

        $query = OmsetHarian::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun);

        if ($warungId) {
            $query->where('warung_id', $warungId);
        }

        return view('exports.rekap_excel', [
            'data' => $query->get()
        ]);
    }
}
