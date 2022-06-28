<?php

namespace App\Exports;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;

class ItemPermintaanExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
    //     //
    // }

    protected $datatemp;

    public function __construct($datatemp)
    {
        $this->datatemp = $datatemp;
    }

    public function view(): View
    {
        return view('admin.permintaan.export.excelitem', 
        [
            'datatemp'=>$this->datatemp,
        ]);
    }
}
