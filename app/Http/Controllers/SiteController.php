<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Illuminate\Http\Request;
use Auth;

class SiteController extends Controller
{
    public function index()
    {
        return view('admin.site.index');
    }

    public function getAll()
    {
        $data = Site::all();
        return datatables()->of($data)->make(true);
    }

    public function edit($id)
    {
        try {
            $data = Site::find($id);
            return response()->json(['status'=>200, 'data'=>$data]);
        } catch (\Throwable $th) {
            return response()->json(['status'=>422, 'text'=>'Data tidak ada']);
        }
    }

    public function update(Request $request)
    {
        try {
            Site::find($request->id)->update($request->except(['_token','id']));
            return response()->json(['text'=>'Data berhasil diubah!','status'=>200]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['text'=>'Data gagal diubah!','status'=>422]);
        }
    }

    public function store(Request $request)
    {
        try {
            Site::create($request->except(['_token']));
            return response()->json(['text'=>'Data berhasil disimpan!','status'=>201]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['text'=>'Data gagal disimpan!','status'=>422]);
        }
    }

    public function destroy(Request $request)
    {
        try {
            Site::find($request->id)->delete();
            return response()->json(['text'=>'Data berhasil dihapus!','status'=>200]);
        } catch (\Throwable $th) {
            return response()->json(['text'=>'Data gagal dihapus!','status'=>422]);
            //throw $th;
        }
    }
}
