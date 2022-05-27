<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class MaterialRequestExcel implements FromView
{
    // /**
    // * @return \Illuminate\Support\Collection
    // */
    // public function collection()
    // {
    //     //
    // }

    protected $datatemp, $tglawal, $tglakhir;

    public function __construct($datatemp, $tglawal, $tglakhir)
    {
        $this->datatemp = $datatemp;
        $this->tglawal = $tglawal;
        $this->tglakhir = $tglakhir;
    }

    public function view(): View
    {
        return view('admin.laporan.material-request.export.excel', 
        [
            'datatemp'=>$this->datatemp,
            'tglawal'=>$this->tglawal,
            'tglakhir'=>$this->tglakhir
        ]);
    }
}
