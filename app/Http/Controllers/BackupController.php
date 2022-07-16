<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BackupController extends Controller
{
    public function index()
    {
        return view('admin.backup.index');
    }

    public function backup()
    {
        try {
            \Artisan::call('backup:run');
            return response()->json(['text'=>'Data berhasil dibackup!', 'status'=>200]);
        } catch (\Throwable $th) {
            dd($th);
        }
    }
}
