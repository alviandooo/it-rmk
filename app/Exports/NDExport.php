<?php

namespace App\Exports;

use App\Models\Item;
use App\Models\ItemKeluar;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\Http;

use Maatwebsite\Excel\Concerns\FromCollection;

class NDExport implements FromView
{
    // /**
    // * @return \Illuminate\Support\Collection
    // */
    // public function collection()
    // {
    //     //
    // }
    protected $datafinal;

    public function __construct($datafinal)
    {
        $this->datafinal = $datafinal;
    }

    public function view(): View
    {
        return view('admin.item.export.network-device-excel', [
            'aset' => $this->datafinal
        ]);

    }
}
