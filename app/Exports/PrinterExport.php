<?php

namespace App\Exports;

use App\Models\Item;
use App\Models\ItemKeluar;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\Http;

use Maatwebsite\Excel\Concerns\FromCollection;

class PrinterExport implements FromView
{
    // /**
    // * @return \Illuminate\Support\Collection
    // */
    // public function collection()
    // {
    //     //
    // }

    public function view(): View
    {
        $data = Item::with(['kategori'])->where('kategori_id', '2')->get();
        // $response = Http::get('http://localhost/hr-rmk2/public/api/karyawan/all/data');
        // $datakaryawan = json_decode($response)->data;

        $final = array();
        $temp = [];

        foreach ($data as $key => $value) {
            $temp['kode_item'] = $value->kode_item;
            $temp['kategori'] = $value->kategori->kategori;
            $temp['nama'] = $value->nama_item;
            $temp['serie'] = $value->serie_item;
            $temp['merk'] = $value->merk;
            $temp['kondisi'] = $value->status_fisik;
            $temp['status'] = $value->status_item;
            
            //cek apakah item digunakan
            if($value->status_item != '1'){
                $nip = ItemKeluar::where('kode_item', $value->kode_item)->orderBy('created_at','desc')->first();
                $response = Http::get('http://localhost/hr-rmk2/public/api/karyawan/'.$nip->nip);
                $datakaryawan = json_decode($response)[0];
                $temp['user'] = $datakaryawan->nama;
                $temp['jabatan'] = $datakaryawan->jabatan->jabatan;

            }else{
                $temp['user'] = '-';
                $temp['jabatan'] = '-';
            }

            array_push($final, $temp);

        }

        return view('admin.item.export.laptop-excel', [
            'laptop' => $final
        ]);
    }
}
