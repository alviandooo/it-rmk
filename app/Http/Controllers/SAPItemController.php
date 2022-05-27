<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class SAPItemController extends Controller
{
    public function index()
    {
        $item = Item::all();
        return view('admin.sap.index', compact(['item']));
    }

    public function store(Request $request)
    {
        try {
            Item::find($request->id)->update($request->except(['_token','id']));

            return response()->json(['text'=>'Data berhasil disimpan!', 'status'=>201]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['text'=>'Data gagal disimpan!', 'status'=>422]);
        }
    }

    public function edit($id)
    {
        try {
            $data = Item::find($id);
            return response()->json($data);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
