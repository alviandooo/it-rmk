<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TransaksiExport implements FromView
{
    // /**
    // * @return \Illuminate\Support\Collection
    // */
    // public function collection()
    // {
    //     //
    // }

    protected $final, $jenis_transaksi;

    public function __construct($final, $jenis_transaksi)
    {
        $this->final = $final;
        $this->jenis_transaksi = $jenis_transaksi;
    }

    public function view(): View
    {
        if($this->jenis_transaksi != '5'){
            return view('admin.laporan.transaksi.export.excel', ['final'=>$this->final]);
        }else{
            return view('admin.laporan.transaksi.export.network-device-excel', ['data'=>$this->final]);
        }
    }
}
