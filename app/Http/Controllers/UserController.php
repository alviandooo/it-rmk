<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Auth;

class UserController extends Controller
{
    public function index()
    {
        $response = Http::get('http://localhost:8082/hr-rmk2/public/api/karyawan/all/data');
        $datakaryawan = json_decode($response);
        return view('admin.users.index',compact(['datakaryawan']));
    }

    public function all()
    {
        if (Auth::user()->nip == '88888888') {
            $data = User::all();
        }else{
            $data = User::where('nip',Auth::user()->nip)->get();
        }
        return datatables()->of($data)->make(true);
    }

    public function edit($id)
    {
        return response()->json(User::find($id));
    }

    public function update(Request $request)
    {
        try {
            if($request->password == null){
                User::find($request->id)->update([
                    'name'=> $request->nama,
                    'status_aktif'=> $request->status_aktif,
                    'email'=> $request->email,
                ]);    
            }else{
                User::find($request->id)->update([
                    'status_aktif'=> $request->status_aktif,
                    'email'=> $request->email,
                    'name'=> $request->nama,
                    'password'=>bcrypt($request->password),
                ]);
            }
            return response()->json(['text'=>'User berhasil diubah!', 'status'=>200]);

        } catch (\Throwable $th) {
            return response()->json(['text'=>'User gagal diubah! <br><br>'.$th->errorInfo[2], 'status'=>422]);
        }

    }

    public function store(Request $request)
    {
        try {
            // User::create(array_merge($request->except(['_token']), ['role'=>'1']));
            User::create([
                'nip'=>$request->nip,
                'role'=>'1',
                'name'=>$request->name,
                'email'=> $request->email,
                'password'=>bcrypt($request->password),
            ]);
            return response()->json(['text'=>'User baru berhasil ditambahkan!', 'status'=>201]);
        } catch (\Throwable $th) {
            return response()->json(['text'=>'User baru gagal ditambahkan! <br><br>'.$th->errorInfo[2] , 'status'=>422]);

        }
    }

    public function destroy(Request $request)
    {
        try {
            User::destroy($request->id);
            return response()->json(['text'=>'User berhasil dihapus!','status'=>200]);
        } catch (\Throwable $th) {
            return response()->json(['text'=>'User gagal dihapus!','status'=>422]);
        }
    }
}
