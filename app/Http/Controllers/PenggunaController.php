<?php

namespace App\Http\Controllers;

use App\Exports\PenggunaExport;
use App\Models\Item;
use App\Models\ItemKeluar;
use App\Models\ItemMasuk;
use App\Models\ItemPerbaikan;
use App\Models\Kerusakan;
use Illuminate\Http\Request;
use PDF;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;

class PenggunaController extends Controller
{
    public function index()
    {
        $response = Http::get('http://localhost:8082/hr-rmk2/public/api/departemen/all');
        $datadepartemen = json_decode($response);
        return view('admin.pengguna.index', compact(['datadepartemen']));
    }

    public function all1()
    {
        $response = Http::get('http://localhost:8082/hr-rmk2/public/api/karyawan/all/data');
        $datakaryawan = json_decode($response);

        $datamasuk = ItemMasuk::where('nip','!=', null)->get();
        $datakeluar = ItemKeluar::selectRaw('*, count(*) as jumlah_item')->groupBy('nip')->get();
        $datakerusakan = Kerusakan::get();
        $dataperbaikan = ItemPerbaikan::get();
        $data = collect(array_merge($datamasuk->toArray(), $datakeluar->toArray(), $datakerusakan->toArray(), $dataperbaikan->toArray()))->groupBy('nip');
        $result=[];
        $final = array();
        $niptemp="";

        foreach ($data as $key => $im) {
            $niptemp = $key;
            foreach ($datakaryawan as $key1 => $dk) {
                if($dk->nip == $niptemp){
                    $result['nama'] = $dk->nama;
                    $result['nip'] = $dk->nip;
                    $result['departemen'] = $dk->departemen->departemen;
                    $result['jabatan'] = $dk->jabatan->jabatan;
                    break;
                }
            }
            foreach ($im as $k => $v) {
                if(isset($v['jumlah_item'])){
                    $result['jumlah_item'] = $v['jumlah_item'];
                }else{
                }
            }
            array_push($final,  $result);
        }
        return datatables()->of($final)->make(true);
    }

    public function all($departemen_id)
    {
        
        $response = Http::get('http://localhost:8082/hr-rmk2/public/api/karyawan/all/data');
        //     $response = Http::get('http://localhost:8082/hr-rmk2/public/api/karyawan/departemen/'.$departemen_id);

        $datakaryawan = json_decode($response);

        $item = Item::with('item_keluar')->where('status_item', '2')->where('kategori_id','!=','4')->get();
        $result=[];
        $final = array();
        $finaltemp = array();
        $nip_temp ="";
        foreach ($item as $key => $value) {
            $nip_temp ="";
            //data item
            $nip_temp = $value->item_keluar->nip;
            foreach ($datakaryawan as $key1 => $dk) {
                //data karyawan
                if($dk->nip == $nip_temp){
                    $result['nama'] = $dk->nama;
                    $result['nip'] = $dk->nip;
                    $result['departemen'] = $dk->departemen->departemen;
                    $result['departemen_id'] = $dk->departemen->id;
                    $result['jabatan'] = $dk->jabatan->jabatan;
                    $result['kode_item'] = $value->kode_item;
                    $result['nama_item'] = $value->nama_item;
                    $result['serie_item'] = $value->serie_item;
                    $result['merk'] = $value->merk;
                    // $result['type'] = $dk->nip." - ".$dk->nama." - ".$dk->jabatan->jabatan;
                }

            }
            
            if ($result != []) {
                array_push($finaltemp, $result);
            }

            // array_push($final, $result);
        }

        if ($departemen_id != 0) {
            foreach ($finaltemp as $keytemp => $valuetemp) {
                if($valuetemp['departemen_id'] == $departemen_id){
                    array_push($final, $valuetemp);
                }
            }
        }else{
            $final = $finaltemp;
        }

        $datagroup = collect($final)->groupBy(['nama']);
        $temp = [];
        $dtfinal = array();
        $nip_temp = "";
        foreach ($datagroup as $key => $value) {
            foreach ($value as $key1 => $v) {
                $temp['nip'] = $v['nip'];
                $temp['nama'] = $v['nama'];
                $temp['jabatan'] = $v['jabatan'];
                $temp['departemen'] = $v['departemen'];
                $temp['jumlah_item'] = $key1+1;
            }

            array_push($dtfinal, $temp);
        }

        return datatables()->of($dtfinal)->make(true);
    }

    public function detail($nip)
    {
        // "ip"/hr-rmk2/public/api/karyawan/{nip}
        $response = Http::get('http://localhost:8082/hr-rmk2/public/api/karyawan/'.$nip);
        $datakaryawan = json_decode($response);
        return view('admin.pengguna.detail',compact(['datakaryawan']));   
    }

    public function riwayatPengguna($nip)
    {
        $masuk = ItemMasuk::with('item')->where('nip',$nip)->get();

        $keluar = ItemKeluar::with(['item'])->doesntHave('item_masuk')->whereRelation('item','kategori_id','!=','6')->where('nip',$nip)->get();

        // $data = collect(array_merge($masuk->toArray(), $keluar->toArray(), $kerusakan->toArray(), $perbaikan->toArray()));
        $data = array();
        
        // $masuk = ItemMasuk::where('nip',$nip)->get();
        // $keluar = ItemKeluar::where('nip',$nip)->get();
        // $kerusakan = Kerusakan::where('nip',$nip)->get();
        // $perbaikan = ItemPerbaikan::where('nip',$nip)->get();
        
        foreach ($keluar as $key => $k) {
            array_push($data, ['kode_item'=>$k->kode_item, 'merk'=>$k->item->merk, 'serie_item'=>$k->item->serie_item,'tanggal'=>$k->tanggal, 'jenis'=>'DIGUNAKAN', 'deskripsi'=>$k->item->deskripsi, 'nama'=>$k->item->nama_item]);
        }

        foreach ($masuk as $key => $m) {
            array_push($data, ['kode_item'=>$m->kode_item, 'merk'=>$m->item->merk, 'serie_item'=>$m->item->serie_item,'tanggal'=>$m->tanggal, 'jenis'=>'DIKEMBALIKAN', 'deskripsi'=>$m->item->deskripsi, 'nama'=>$m->item->nama_item]);
        }
        
        return datatables()->of($data)->make(true);

    }

    public function getRiwayatPenggunaService($nip)
    {
        $kerusakan = Kerusakan::with('item')->where('nip',$nip)->get();
        $perbaikan = ItemPerbaikan::with('item')->where('nip',$nip)->get();
        $data = array();
        foreach ($kerusakan as $key => $kr) {
            array_push($data, ['kode_item'=>$kr->kode_item, 'merk'=>$kr->item->merk, 'serie_item'=>$kr->item->serie_item,'tanggal'=>$kr->tanggal, 'jenis'=>'KERUSAKAN', 'deskripsi'=>$kr->item->deskripsi, 'analisa_kerusakan'=>$kr->analisa_kerusakan, 'nama'=>$kr->item->nama_item]);
        }
        foreach ($perbaikan as $key => $p) {
            array_push($data, ['kode_item'=>$p->kode_item, 'merk'=>$p->item->merk, 'serie_item'=>$p->item->serie_item,'tanggal'=>$p->tanggal_perbaikan, 'jenis'=>'PERBAIKAN/UPGRADE', 'deskripsi'=>$p->item->deskripsi, 'analisa_kerusakan'=>'-', 'nama'=>$p->item->nama_item]);
        }
        return datatables()->of($data)->make(true);
    }

    public function getRiwayatPenggunaItemService($nip)
    {
        //get item keluar dengan nip dan kategori consumable
        $item = ItemKeluar::with(['item','item_service','item_service.item_perbaikan'])->whereRelation('item','kategori_id','6')->where('nip',$nip)->get();
        $data = array();
        foreach ($item as $key => $i) {
            array_push($data, ['kode_item'=>$i->kode_item, 'tanggal'=>$i->tanggal, 'merk'=>$i->item->merk, 'nama'=>$i->item->nama_item, 'jumlah'=>( isset($i->item_service[0]->jumlah) ? $i->item_service[0]->jumlah : '1'), 'kode_item_perbaikan'=>isset($i->item_service[0]->item_perbaikan->kode_item) ? $i->item_service[0]->item_perbaikan->kode_item : '-']);
        }
        
        return datatables()->of($data)->make(true);

    }

    public function datalaporan()
    {
        $response = Http::get('http://localhost:8082/hr-rmk2/public/api/karyawan/all/data');
        $datakaryawan = json_decode($response);

        $item = Item::with('item_keluar','kategori')->where('status_item', '2')->where('kategori_id', '!=','4')->get();
        $itemkeluar = ItemKeluar::orderBy('tanggal','desc')->get();
        // $datamasuk = ItemMasuk::where('nip','!=', null)->get();
        // $datakerusakan = Kerusakan::get();
        // $dataperbaikan = ItemPerbaikan::get();
        $result=[];
        $final = array();
        $nip_temp ="";
        foreach ($item as $key => $value) {
            $nip_temp = $value->item_keluar->nip;
            foreach ($datakaryawan as $key1 => $dk) {
                if($dk->nip == $nip_temp){
                    $result['nama'] = $dk->nama;
                    $result['jabatan'] = $dk->jabatan->jabatan;
                    // $result['type'] = $dk->nip." - ".$dk->nama." - ".$dk->jabatan->jabatan;
                    // $result['departemen'] = $dk->departemen->departemen;
                    $result['kode_item'] = $value->kode_item;
                    $result['kategori'] = $value->kategori->kategori;
                    $result['merk'] = $value->merk;
                    $result['deskripsi'] = $value->deskripsi;

                    break;
                }
            }

            array_push($final, $result);
        }
        
        return datatables()->of($final)->make(true);
    }

    public function laporan()
    {
        return view('admin.laporan.pengguna.pengguna');
    }

    public function export($jenis_export)
    {
        $response = Http::get('http://localhost:8082/hr-rmk2/public/api/karyawan/all/data');
        $datakaryawan = json_decode($response);

        $item = Item::with('item_keluar','kategori')->where('status_item', '2')->where('kategori_id', '!=','4')->get();
        $itemkeluar = ItemKeluar::orderBy('tanggal','desc')->get();
        // $datamasuk = ItemMasuk::where('nip','!=', null)->get();
        // $datakerusakan = Kerusakan::get();
        // $dataperbaikan = ItemPerbaikan::get();
        $result=[];
        $final = array();
        $nip_temp ="";

        foreach ($item as $key => $value) {
            $nip_temp = $value->item_keluar->nip;
            foreach ($datakaryawan as $key1 => $dk) {
                if($dk->nip == $nip_temp){
                    $result['nama'] = $dk->nama;
                    // $result['nip'] = $dk->nip;
                    // $result['departemen'] = $dk->departemen->departemen;
                    $result['jabatan'] = $dk->jabatan->jabatan;
                    $result['kode_item'] = $value->kode_item;
                    $result['kategori'] = $value->kategori->kategori;
                    $result['nama_item'] = $value->nama_item;
                    $result['serie_item'] = $value->serie_item;
                    $result['merk'] = $value->merk;
                    $result['deskripsi'] = $value->deskripsi;
                    $result['type'] = $dk->nama." - ".$dk->jabatan->jabatan;
                    break;
                }
            }

            array_push($final, $result);

        }

        $totalitem = count($item);
        
        $group = collect($final)->groupBy('type');
        if ($jenis_export == '1') {
            //excel
            return Excel::download(new PenggunaExport($group), 'Pengguna.xlsx');
        }else if($jenis_export == '2'){
            //pdf
            $pdf = PDF::loadView('admin.laporan.pengguna.export.pdf', compact(['group','totalitem']))->setPaper('a4', 'potrait')->setWarnings(false);
            return $pdf->stream();
        }
    }
    
}
