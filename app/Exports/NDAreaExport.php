<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class NDAreaExport implements FromView
{

    public function __construct($data)
    {
        $this->data = $data;
    }
    
    public function view(): View
    {
        return view('admin.network_device.export.excel', [
            'data' => $this->data
        ]);
    }
}
