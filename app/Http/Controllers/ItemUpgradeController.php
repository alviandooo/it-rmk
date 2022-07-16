<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemUpgrade;
use Illuminate\Http\Request;
use Nette\Utils\Json;

class ItemUpgradeController extends Controller
{

    public function getAll()
    {
        $data = ItemUpgrade::with(['item','item.kategori','item_part'])->get();
        return datatables()->of($data)->make(true);
    }

    public function getByKodeItem($id)
    {
        $kode_item = Item::find($id)->kode_item;
        $data = ItemUpgrade::with(['item','item.kategori','item_part'])->where('kode_item', $kode_item)->get();
        return datatables()->of($data)->make(true);
    }

    public function store(Request $request)
    {
        try {
            $datakode = explode(',',$request->kode_item_upgrade);
            $datajumlah = explode(',',$request->jumlah);
            $tanggal = date("Y-m-d", strtotime($request->tanggal));
            $array = array();
            
            foreach ($datakode as $key => $value) {
                array_push($array, ['kode_item_upgrade'=>$datakode[$key], 'jumlah'=>$datajumlah[$key], 'tanggal'=>$tanggal, 'kode_item'=>$request->kode_item]);

                $d = Item::where('kode_item', $value);
                $d->update(['jumlah'=> ($d->first()->jumlah) - ($datajumlah[$key]) ]);
                 
            }
            //simpan data
            ItemUpgrade::insert($array);

            // kurangi jumah stok
            return response()->json(['text'=>'Data berhasil ditambahkan!', 'status'=>201]);
            
        } catch (\Throwable $th) {
            dd($th);
            return response()->json(['text'=>'Data gagal ditambahkan!', 'status'=>422]);
            //throw $th;
        }
    }

    public function destroy(Request $request)
    {
        try {
            $itemupgrade = ItemUpgrade::find($request->id);
            $item = Item::where('kode_item', $itemupgrade->kode_item_upgrade);
            $item->update(['jumlah' => ($item->jumlah + $itemupgrade->jumlah)]);
            $itemupgrade->delete();
            return response()->json(['text'=>'Data berhasil dihapus!', 'status'=>200]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['text'=>'Data gagal dihapus!', 'status'=>422]);
        }
    }
}
