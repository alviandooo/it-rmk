<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemKeluar;
use App\Models\ItemMasuk;
use App\Models\Kerusakan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use PDF;
use Auth;


class KerusakanController extends Controller
{
    public function index()
    {
        $item = Item::where('site', Auth::user()->lokasi)->get();
        $sparepart = Item::where('site', Auth::user()->lokasi)->whereIn('kategori_id',['6'])->where('jumlah','!=','0')->get();
        $response = Http::get('http://localhost:8082/hr-rmk2/public/api/karyawan/all/data');
        $datakaryawan = json_decode($response);
        return view('admin.inventaris.kerusakan.index',compact(['item','datakaryawan','sparepart']));
    }

    public function all()
    {
        $data = Kerusakan::whereRelation('item','site', Auth::user()->lokasi)->with(['item.kategori'])->orderBy('tanggal', 'desc')->get();

        $response = Http::get('http://localhost:8082/hr-rmk2/public/api/karyawan/all/data');

        $datakaryawan = json_decode($response);
        $result=[];
        $final = array();
        $niptemp="";
        foreach ($data as $key => $d) {
            $niptemp = $d->nip;
            foreach ($datakaryawan as $key => $dk) {
                if($dk->nip == $niptemp){
                    $result['nama'] = $dk->nama;
                    $result['jabatan'] = $dk->jabatan->jabatan;
                    $result['departemen'] = $dk->departemen->departemen;
                    // $result['area_kerja'] = $dk->area_kerja;
                    $result['nip'] = $dk->nip;

                    break;
                }
            }
            $result['id']=$d->id;
            $result['tanggal']=$d->tanggal;
            $result['kode_item']=$d->kode_item;
            $result['serie_item']=$d->item->serie_item;
            $result['kategori']=$d->item->kategori->kategori;
            $result['nama_item']=$d->item->nama_item;
            $result['analisa_kerusakan']=$d->analisa_kerusakan;
            $result['status']=$d->status;

            array_push($final,  $result);
        }
        return datatables()->of($final)->make(true);
    }

    public function select2item($nip)
    {
        if ($nip == '11111111') {
            
            $itemnd = Item::where('site', Auth::user()->lokasi)->where('kategori_id', '4')->get()->toArray();

            $itemkembali = ItemMasuk::whereRelation('item.item_site', 'site' ,Auth::user()->lokasi)->where('nip',$nip)->get();
            $kodenotin = array();
            foreach ($itemkembali as $key => $value) {
                $countkeluar = ItemKeluar::whereRelation('item.item_site', 'site' ,Auth::user()->lokasi)->where('kode_item',$value->kode_item)->where('nip',$nip)->count();
                $countmasuk = ItemMasuk::whereRelation('item.item_site', 'site' ,Auth::user()->lokasi)->where('kode_item',$value->kode_item)->where('nip',$nip)->count();
    
                if($countkeluar == $countmasuk){
                    array_push($kodenotin, $value->kode_item);
                }
            }
    
            if($nip == '-'){
                $item1 = Item::whereRelation('item.item_site', 'site' ,Auth::user()->lokasi)->with(['item_keluar'])->where('status_item', '2')->where('kategori_id','!=','4')->get()->toArray();
            }else{
                $item1 = Item::whereRelation('item.item_site', 'site' ,Auth::user()->lokasi)->with(['item_keluar'])->whereRelation('item_keluar', 'nip', $nip)->where('status_item', '2')->where('kategori_id','!=','4')->whereNotIn('kode_item', $kodenotin)->get()->toArray();
            }

            $item = array_merge($itemnd, $item1);

        }else{
            $itemkembali = ItemMasuk::whereRelation('item.item_site', 'site' ,Auth::user()->lokasi)->where('nip',$nip)->get();
            $kodenotin = array();
            foreach ($itemkembali as $key => $value) {
                $countkeluar = ItemKeluar::whereRelation('item.item_site', 'site' ,Auth::user()->lokasi)->where('kode_item',$value->kode_item)->where('nip',$nip)->count();
                $countmasuk = ItemMasuk::whereRelation('item.item_site', 'site' ,Auth::user()->lokasi)->where('kode_item',$value->kode_item)->where('nip',$nip)->count();
    
                if($countkeluar == $countmasuk){
                    array_push($kodenotin, $value->kode_item);
                }
            }
    
            if($nip == '-'){
                $item = Item::with(['item_keluar'])->where('site' ,Auth::user()->lokasi)->where('status_item', '2')->where('kategori_id','!=','4')->get();
            }else{
                $item = Item::with(['item_keluar'])->whereRelation('item_keluar', 'nip', $nip)->where('status_item', '2')->where('site' ,Auth::user()->lokasi)->where('status_item', '2')->where('kategori_id','!=','4')->whereNotIn('kode_item', $kodenotin)->get();
            }
        }
        
        if (count($item) != 0) {
            return response()->json(['data'=>$item, 'status'=>200]);
        }else{
            return response()->json(['data'=>'Item tidak ada!', 'status'=>422]);
        }
    }
    
    public function store(Request $request)
    {
        try {
            Kerusakan::create(array_merge($request->except(['_token','tanggal']), ['tanggal'=>date("Y-m-d", strtotime($request->tanggal))]));
            // update status_item => sedang diperbaiki di table item
            $item = Item::where('kode_item', $request->kode_item);
            if($item->first()->kategori_id != '6'){
                $item->update(['status_fisik'=>'3']);
            }

            return response()->json(['text'=>'Data berhasil ditambahkan!','status'=>201]);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th);
        }
    }

    public function edit($id)
    {
        return response()->json(Kerusakan::find($id));
    }

    public function update(Request $request)
    {
        try {
            Kerusakan::find($request->id)->update(array_merge($request->except(['_token','id','tanggal']), ['tanggal'=>date("Y-m-d", strtotime($request->tanggal))]));
            return response()->json(['text'=>'Data berhasil diubah!','status'=>200]);
        } catch (\Throwable $th) {
            return response()->json(['text'=>'Data gagal diubah!','status'=>422]);
            
        }
    }

    public function pdf($id)
    {
        $data = Kerusakan::with(['item','item.kategori','item.item_keluar'])->whereRelation('item','site' ,Auth::user()->lokasi)->where('status_item', '2')->where('id',$id)->get();

        $response = Http::get('http://localhost:8082/hr-rmk2/public/api/karyawan/all/data');

        $datakaryawan = json_decode($response);
        $result=[];
        $final = array();
        $niptemp="";
        foreach ($data as $key => $d) {
            $niptemp = $d->nip;
            foreach ($datakaryawan as $key => $dk) {
                if($dk->nip == $niptemp){
                    $result['nama'] = $dk->nama;
                    $result['jabatan'] = $dk->jabatan->jabatan;
                    $result['departemen'] = $dk->departemen->departemen;
                    // $result['area_kerja'] = $dk->area_kerja;
                    $result['nip'] = $dk->nip;

                    break;
                }
            }
            $result['id']=$d->id;
            $result['tanggal']=$d->tanggal;
            if(isset($d->item->item_keluar->tanggal)){
                $result['tanggal_terima']=$d->item->item_keluar->tanggal;
            }else{
                $result['tanggal_terima']= '-';
            }
            $result['kode_item']=$d->kode_item;
            $result['merk']=$d->item->merk;
            $result['kategori']=$d->item->kategori->kategori;
            $result['nama_item']=$d->item->nama_item;
            $result['serie_item']=$d->item->serie_item;
            $result['analisa_kerusakan']=$d->analisa_kerusakan;

            array_push($final,  $result);
        }
        $pdf = PDF::loadView('admin.inventaris.kerusakan.export.pdf', compact(['final']))->setPaper('a4', 'potrait')->setWarnings(false);
        return $pdf->stream();
    }
}
