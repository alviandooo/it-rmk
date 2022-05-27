<?php

namespace App\Exports;


use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;

class PenggunaExport implements FromView
{
    protected $datatemp, $tglawal, $tglakhir;

    public function __construct($group)
    {
        $this->group = $group;
    }

    public function view(): View
    {
        return view('admin.laporan.pengguna.export.excel', 
        [
            'group'=>$this->group,
        ]);
    }
}
