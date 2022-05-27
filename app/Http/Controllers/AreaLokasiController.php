<?php

namespace App\Http\Controllers;

use App\Models\AreaLokasiNetworkDevice;
use App\Models\LokasiNetworkDevice;
use Illuminate\Http\Request;

class AreaLokasiController extends Controller
{
    public function index()
    {
        $area = AreaLokasiNetworkDevice::all();
        return view('admin.area_lokasi.index', compact(['area']));
    }

    public function allarea()
    {
        $data = AreaLokasiNetworkDevice::with(['lokasi_network_device'])->get();
        return datatables()->of($data)->make(true);
    }

    public function alllokasi()
    {
        $data = LokasiNetworkDevice::with('area_lokasi_network_device')->get();
        return datatables()->of($data)->make(true);
    }

    public function storearea(Request $request)
    {
        try {
            AreaLokasiNetworkDevice::create($request->except('_token'));
            return response()->json(['text'=>'Data berhasil ditambahkan!', 'status'=>201]);
        } catch (\Throwable $th) {
            dd($th);
            return response()->json(['text'=>'Data gagal ditambahkan!', 'status'=>422]);
            //throw $th;
        }
    }

    public function storelokasi(Request $request)
    {
        try {
            LokasiNetworkDevice::create($request->except('_token'));
            return response()->json(['text'=>'Data berhasil ditambahkan!', 'status'=>201]);
        } catch (\Throwable $th) {
            return response()->json(['text'=>'Data gagal ditambahkan!', 'status'=>422]);
            //throw $th;
        }
    }

    public function editarea($id)
    {
        return response()->json(AreaLokasiNetworkDevice::where('id',$id)->first());
    }

    public function editlokasi($id)
    {
        return response()->json(LokasiNetworkDevice::with(['area_lokasi_network_device'])->where('id',$id)->first());
    }

    public function updatearea(Request $request)
    {
        try {
            AreaLokasiNetworkDevice::find($request->id)->update($request->except('id','_token'));
            return response()->json(['text'=>'Data berhasil diubah!', 'status'=>200]);
        } catch (\Throwable $th) {
            return response()->json(['text'=>'Data gagal diubah!', 'status'=>422]);
            //throw $th;
        }
    }

    public function updatelokasi(Request $request)
    {
        try {
            LokasiNetworkDevice::find($request->id)->update($request->except('id','_token'));
            return response()->json(['text'=>'Data berhasil diubah!', 'status'=>200]);
        } catch (\Throwable $th) {
            return response()->json(['text'=>'Data gagal diubah!', 'status'=>422]);
            //throw $th;
        }
    }

    public function destroyarea(Request $request)
    {
        try {
            AreaLokasiNetworkDevice::find($request->id)->delete();
            return response()->json(['text'=>'Data berhasil dihapus!', 'status'=>200]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['text'=>'Data gagal dihapus!', 'status'=>422]);
        }
    }

    public function destroylokasi(Request $request)
    {
        try {
            LokasiNetworkDevice::find($request->id)->delete();
            return response()->json(['text'=>'Data berhasil dihapus!', 'status'=>200]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['text'=>'Data gagal dihapus!', 'status'=>422]);
        }
    }
}
