<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use datatables;

class KategoriController extends Controller
{
    public function index()
    {
        return view('admin.kategori.index');
    }

    public function getAll()
    {
        $data = Kategori::all();
        // return response()->json(['data'=>$data]);
        return datatables()->of($data)->make(true);

    }

    public function edit($id)
    {
        try {
            $data = Kategori::find($id);
            return response()->json($data);
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function update(Request $request)
    {
        try {
            Kategori::find($request->id)->update($request->except(['_token','id']));
            return response()->json(['text'=>'Kategori berhasil diubah!','status'=>200]);
        } catch (\Throwable $th) {
            return response()->json(['text'=>'Kategori gagal diubah!','status'=>422]);
        }
    }

    public function store(Request $request)
    {
        try {
            Kategori::create($request->except(['_token']));
            return response()->json(['text'=>'Kategori berhasil disimpan!','status'=>201]);
        } catch (\Throwable $th) {
            return response()->json(['text'=>'Kategori gagal disimpan!','status'=>422]);
        }
    }

    public function destroy(Request $request)
    {
        Kategori::destroy($request->id);
        return response()->json(['text'=>'Kategori berhasil dihapus!','status'=>200]);
    }
}
