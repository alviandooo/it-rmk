<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemKeluar;
use App\Models\ItemPerbaikan;
use App\Models\ItemService;
use App\Models\Kerusakan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ItemPerbaikanController extends Controller
{
    public function index()
    {
        $response = Http::get('http://localhost:8082/hr-rmk2/public/api/karyawan/all/data');
        $datakaryawan = json_decode($response);
        $item = Item::whereIn('status_fisik', ['1','2','3'])->get();
        return view('admin.inventaris.perbaikan.index', compact(['item','datakaryawan']));
    }

    public function getAll()
    {
        $itemperbaikan = ItemPerbaikan::with(['item' => function ($query)
        {
            $query->select('*');
        },
        'item.kategori'=>function ($query)
        {
            $query->select('*');
        }])->orderBy('tanggal_perbaikan', 'desc')->get();

        $response = Http::get('http://localhost:8082/hr-rmk2/public/api/karyawan/all/data');
        
        $datakaryawan = json_decode($response);
        $result=[];
        $final = array();
        $niptemp="";

        foreach ($itemperbaikan as $key => $im) {
            $niptemp = $im->nip;
            foreach ($datakaryawan as $key => $dk) {
                if($dk->nip == $niptemp){
                    $result['nama'] = $dk->nama;
                    $result['jabatan'] = $dk->jabatan->jabatan;
                    $result['departemen'] = $dk->departemen->departemen;
                    $result['area_kerja'] = $dk->area_kerja->nama_area;
                    $result['nip'] = $dk->nip;

                    break;
                }
            }
            $result['id']=$im->id;
            $result['tanggal_perbaikan']=$im->tanggal_perbaikan;
            $result['kode_item']=$im->kode_item;
            $result['jenis_perbaikan']=$im->jenis_perbaikan;
            $result['deskripsi']=$im->deskripsi;
            $result['nama_item']=$im->item->nama_item;
            $result['merk']=$im->item->merk;
            $result['serie_item']=$im->item->serie_item;
            $result['kategori']=$im->item->kategori->kategori;

            $result['keterangan']=$im->keterangan;
            $result['deskripsi']=$im->deskripsi;

            $result['created_at']=$im->item->created_at;

            array_push($final,  $result);
        }

        return datatables()->of($final)->make(true);
    }

    public function store(Request $request)
    {
        try {
            $item = Item::where('kode_item', $request->kode_item)->first();
            ItemPerbaikan::create(array_merge($request->except(['_token','tanggal_perbaikan']), ['tanggal_perbaikan'=>date("Y-m-d", strtotime($request->tanggal_perbaikan))]));
            
            Item::where('kode_item', $request->kode_item)->update(['status_fisik'=>'1']);
            
            return response()->json(['text'=>'Data berhasil ditambahkan', 'status'=>201]);
            
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function selesaiperbaikan(Request $request)
    {
        if(!isset($request->item_service)){
            try {
                $kerusakan = Kerusakan::find($request->kerusakan_id);
                //jadikan array data 
                $array_ip = array();
                array_push($array_ip, [
                    'kode_item'=>$kerusakan->kode_item,
                    'nip'=>$kerusakan->nip,
                    'jenis_perbaikan'=>'2',
                    'tanggal_perbaikan'=>date('Y-m-d'),
                    'deskripsi'=>'-',
                    'keterangan'=>'-',
                ]);
    
                //simpan data ke table item perbaikan
                    //kode_item_kerusakan, nip, jenis_perbaikan=2, tanggal_perbaikan, tanggal_selesai=0000-00-00, deskripsi, keterangan
                    ItemPerbaikan::insert($array_ip);
    
                //ubah status item kerusakan menjadi baik di table item
                Item::where('kode_item', $kerusakan->kode_item)->update(['status_fisik'=>'1']);
    
                //ubah status kerusakan menjadi 1 = selesai
                $kerusakan->update(['status'=>'1']);
                
                return response()->json(['text'=>'Data berhasil diubah!', 'status'=>200]);
            } catch (\Throwable $th) {
                dd($th);
            }
        }else{

            try {
                $kerusakan = Kerusakan::find($request->kerusakan_id);
                //jadikan array data 
                $dataitemservice = json_decode($request->item_service);
    
                $array_ik = array();
                foreach ($dataitemservice as $key => $value) {
                    array_push($array_ik, [
                        'kode_item'=>$value->kode_item,
                        'nip'=>$kerusakan->nip,
                        'tanggal'=>date('Y-m-d'),
                        'deskripsi'=>'-',
                        'status_item'=>'1',
                    ]);
                }

                //simpan data ke table item perbaikan
                    //kode_item_kerusakan, nip, jenis_perbaikan=2, tanggal_perbaikan, tanggal_selesai=0000-00-00, deskripsi, keterangan
                    $ip = ItemPerbaikan::create([
                        'kode_item'=>$kerusakan->kode_item,
                        'nip'=>$kerusakan->nip,
                        'jenis_perbaikan'=>'2',
                        'tanggal_perbaikan'=>date('Y-m-d'),
                        'deskripsi'=>'-',
                        'keterangan'=>'-',
                    ]);
    
                //simpan data ke table item service
                    $array_is = array();
                    foreach ($dataitemservice as $key => $value) {
                        array_push($array_is, [
                            'kode_item_service'=>$value->kode_item,
                            'jumlah'=>$value->jumlah,
                            'nip'=>$kerusakan->nip,
                            'perbaikan_id'=>$ip->id,
                        ]);
                    }
                    ItemService::insert($array_is);
                    
                //simpan data item terpakai di table item keluar / penyerahan
                    //kode_item, tanggal, status_item, nip, deskripsi,
                    ItemKeluar::insert($array_ik);
    
                //kurangi jumlah stok sesuai dengan item terpakai di stok consumable
                    foreach ($dataitemservice as $key => $value) {
                        $jumlah = intval($value->stok) - intval($value->jumlah);
                        Item::where('kode_item', $value->kode_item)->update(['jumlah'=>$jumlah]);
                    }
    
                //ubah status item kerusakan menjadi baik di table item
                Item::where('kode_item', $kerusakan->kode_item)->update(['status_fisik'=>'1']);
    
                //ubah status kerusakan menjadi 1 = selesai
                $kerusakan->update(['status'=>'1']);
                
                return response()->json(['text'=>'Data berhasil diubah!', 'status'=>200]);
            } catch (\Throwable $th) {
                dd($th);
            }
        }
    }

    public function edit($id)
    {
        try {
            $data = ItemPerbaikan::find($id);
            return response()->json($data);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th);
        }
    }

    public function update(Request $request)
    {
        try {
            ItemPerbaikan::find($request->id)->update(array_merge($request->except(['_token','id','tanggal_perbaikan']), ['tanggal_perbaikan'=>date("Y-m-d", strtotime($request->tanggal_perbaikan))]));
            return response()->json(['text'=>'Data berhasil diubah!', 'status'=>200]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['text'=>'Data gagal diubah!', 'status'=>422]);
        }
    }

    public function destroy(Request $request)
    {
        ItemPerbaikan::find($request->id)->delete();
        return response()->json(['text'=>'Data berhasil dihapus!','status'=>200]);
    }
}
