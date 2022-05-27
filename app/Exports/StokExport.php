<?php

namespace App\Exports;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use Maatwebsite\Excel\Concerns\FromCollection;

class StokExport implements FromView
{
    // /**
    // * @return \Illuminate\Support\Collection
    // */
    // public function collection()
    // {
    //     //
    // }

    protected $d;

    public function __construct($d)
    {
        $this->d = $d;
    }

    public function view(): View
    {
        return view('admin.laporan.stok.export.stok-excel', ['d'=>$this->d
        ]);
    }
}
