<?php

namespace App\Http\Controllers;

use App\Models\ItemPermintaan;
use App\Models\Permintaan;
use Illuminate\Http\Request;

class ItemPermintaanController extends Controller
{
    public function edit($id)
    {
        $data = ItemPermintaan::with(['satuan'])->find($id);
        return response()->json($data);
    }

    public function update(Request $request)
    {
        try {
            ItemPermintaan::find($request->id)->update($request->except(['_token','id']));
            return response()->json(['text'=>'Item berhasil diubah!','status'=>200]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['text'=>'Item gagal diubah!','status'=>422]);
        }
    }

    public function updatestatusitem($id, $status)
    {
        try {
            $ip = ItemPermintaan::find($id);
            $ip->update(['status_item_permintaan' => $status]);

            $ro = $ip->ro_no;
            $dataip = ItemPermintaan::where('ro_no', $ro);
            $jumlahdataip = $dataip->count();
            $jumlahdataipprocess = ItemPermintaan::where('ro_no', $ro)->where('status_item_permintaan', '0')->count();
            $jumlahdataipcomplete = ItemPermintaan::where('ro_no', $ro)->where('status_item_permintaan', '1')->count();
            $jumlahdataippending = $dataip->where('status_item_permintaan', '2')->count();
            
            // status permintaan -> 0-process, 1-complete, 3-incomplete, 2-pending
            if($jumlahdataip == $jumlahdataipcomplete){
                $status = '1';
            }else if($jumlahdataip == $jumlahdataippending){
                $status = '2';
            }elseif($jumlahdataip == $jumlahdataipprocess){
                $status = '0';
            }else{
                $status = '3';
            }

            Permintaan::where('ro_no', $ro)->update(['status_permintaan'=>$status]);
            return response()->json(['text'=>'Item berhasil diubah!', 'status'=>200]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['text'=>'Item gagal diubah!', 'status'=>422]);
        }
    }

    public function destroy(Request $request)
    {
        ItemPermintaan::find($request->id)->delete();
        return response()->json(['text'=>'Item berhasil dihapus!', 'status'=>200]);
    }
}
