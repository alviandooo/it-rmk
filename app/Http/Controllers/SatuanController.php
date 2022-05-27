<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Satuan;

class SatuanController extends Controller
{
    public function index()
    {
        return view('admin.satuan.index');
    }

    public function getAll()
    {
        $data = Satuan::all();
        // return response()->json(['data'=>$data]);
        return datatables()->of($data)->make(true);

    }

    public function edit($id)
    {
        try {
            $data = Satuan::find($id);
            return response()->json($data);
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function update(Request $request)
    {
        try {
            Satuan::find($request->id)->update($request->except(['_token','id']));
            return response()->json(['text'=>'Kategori berhasil diubah!','status'=>200]);
        } catch (\Throwable $th) {
            return response()->json(['text'=>'Kategori gagal diubah!','status'=>422]);
        }
    }

    public function store(Request $request)
    {
        try {
            Satuan::create($request->except(['_token']));
            return response()->json(['text'=>'Kategori berhasil disimpan!','status'=>201]);
        } catch (\Throwable $th) {
            return response()->json(['text'=>'Kategori gagal disimpan!','status'=>422]);
        }
    }

    public function destroy(Request $request)
    {
        Satuan::destroy($request->id);
        return response()->json(['text'=>'Kategori berhasil dihapus!','status'=>200]);
    }
}
