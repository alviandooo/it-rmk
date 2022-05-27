<?php

namespace App\Http\Controllers;

use App\Models\AreaLokasiNetworkDevice;
use App\Models\Item;
use App\Models\LokasiNetworkDevice;
use App\Models\NetworkDevice;
use Illuminate\Http\Request;

class NetworkDeviceController extends Controller
{
    public function index()
    {
        $area = AreaLokasiNetworkDevice::all();
        $item = Item::whereIn('kategori_id', [4,6])->where('status_item', '1')->get();
        $lokasi = LokasiNetworkDevice::with(['area_lokasi_network_device'])->get();
        return view('admin.network_device.index', compact(['item','lokasi','area']));
    }

    public function allbyarea()
    {
        $data = NetworkDevice::with(['lokasi_network_device',
        'lokasi_network_device.area_lokasi_network_device'=>function ($query)
        {
            $query->selectRaw('*');
        }])->get();

        $collect = collect($data);
        $group = $collect->groupBy('lokasi_network_device.area_lokasi_network_device.nama_area_lokasi');
        
        $jumlah = 0;
        $datatemp = [];
        $final = array();
        foreach ($group as $key => $value) {
            $datatemp['area'] = $key;
            foreach ($value as $key => $v) {
                $datatemp['id'] = $v->lokasi_network_device->area_lokasi_network_device->id;
                $jumlah = $jumlah + 1;
            }
            $datatemp['jumlah'] = $jumlah;

            array_push($final, $datatemp);
            $jumlah = 0;
        }

        return datatables()->of($final)->make(true);

    }

    public function detailbyarea($area_id)
    {
        $area = AreaLokasiNetworkDevice::find($area_id);
        $data = NetworkDevice::with(['item','lokasi_network_device', 'lokasi_network_device.area_lokasi_network_device' => function ($query)
        {
            $query->select('*');
        }])->whereHas('lokasi_network_device', function ($q) use($area_id)
        {
            $q->where('area_lokasi_network_device_id', '=', $area_id);
        })->get();

        $item = Item::whereIn('kategori_id', [4,6])->get();
        $lokasi = LokasiNetworkDevice::with(['area_lokasi_network_device'])->where('area_lokasi_network_device_id',$area_id)->get();

        return view('admin.network_device.detail', compact(['area','data','lokasi','item']));
    }

    public function detaildatabyarea($area_id)
    {
        // $data = NetworkDevice::with(['lokasi_network_device', 'lokasi_network_device.area_lokasi_network_device' => function ($query)
        // {
        //     $query->select('*');
        // }])->whereHas('lokasi_network_device', function ($q) use($area_id)
        // {
        //     $q->where('area_lokasi_network_device_id', '=', $area_id);
        // })->get();

        $data = NetworkDevice::with(['item', 'lokasi_network_device', 'lokasi_network_device.area_lokasi_network_device' => function ($query)
        {
            $query->select('*');
        }])->whereHas('lokasi_network_device', function ($q) use($area_id)
        {
            $q->where('area_lokasi_network_device_id', '=', $area_id);
        })->get();

        return datatables()->of($data)->make(true);
    }

    public function detaildatabylokasiarea($area_id, $lokasi_id)
    {
        
        $data = NetworkDevice::with(['item', 'lokasi_network_device', 'lokasi_network_device.area_lokasi_network_device' => function ($query)
        {
            $query->select('*');
        }])->whereHas('lokasi_network_device', function ($q) use($area_id)
        {
            $q->where('area_lokasi_network_device_id', '=', $area_id);
        })->where('lokasi_network_device_id',$lokasi_id)->get();

        return datatables()->of($data)->make(true);
    }

    public function detailitem($kode_item)
    {
        $kode_item_baru = str_replace('-','/',$kode_item);
        $id = Item::where('kode_item', $kode_item_baru)->first()->id;
        return redirect()->action('App\Http\Controllers\ItemController@edit',['id'=>$id]);
    }

    public function store(Request $request)
    {
        try {
            $tanggal = date('Y-m-d', strtotime($request->tanggal));
            NetworkDevice::create(array_merge($request->except(['_token','tanggal']), ['tanggal'=>$tanggal]));
            $item = Item::where('kode_item', $request->kode_item)->first();
            if($item->kategori_id == "6"){
                Item::where('kode_item', $request->kode_item)->update([
                    'jumlah'=>$item->jumlah - 1,
                ]);
            }else{
                Item::where('kode_item', $request->kode_item)->update(['status_item'=>'2']);
            }
            return response()->json(['text'=>'Data berhasil ditambahkan!', 'status'=>201]);
        } catch (\Throwable $th) {
            return response()->json(['text'=>'Data gagal ditambahkan!', 'status'=>422]);
            //throw $th;
        }
    }

    public function edit($id)
    {
        return response()->json(NetworkDevice::find($id));
    }

    public function update(Request $request)
    {
        try {
            $tanggal = date('Y-m-d', strtotime($request->tanggal));
            NetworkDevice::find($request->id)->update(array_merge($request->except(['_token','tanggal','id']), ['tanggal'=>$tanggal]));
            return response()->json(['text'=>'Data berhasil diubah!', 'status'=>200]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['text'=>'Data gagal ditambahkan!', 'status'=>422]);
        }
    }

}
