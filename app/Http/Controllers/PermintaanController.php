<?php

namespace App\Http\Controllers;

use App\Exports\ItemPermintaanExport;
use App\Exports\MaterialRequestExcel;
use App\Models\Approval;
use App\Models\ItemPermintaan;
use App\Models\Permintaan;
use App\Models\Satuan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Auth;
use App\Helpers\TanggalIndo;
use App\Models\Item;
use PDF;
use Illuminate\Support\Facades\File; 

class PermintaanController extends Controller
{
    public function index()
    {
        $response1 = Http::get('http://localhost:8082/hr-rmk2/public/api/karyawan/departemen/25');
        $datakaryawanit = json_decode($response1);
        return view('admin.permintaan.index', compact(['datakaryawanit']) );
    }
    
    public function indexApprove()
    {
        $response1 = Http::get('http://localhost:8082/hr-rmk2/public/api/karyawan/departemen/25');
        $datakaryawanit = json_decode($response1);
        return view('admin.permintaan.approve.index', compact(['datakaryawanit']));
    }

    public function getAll()
    {
        $data = Permintaan::orderBy('tanggal', 'desc')->get();
        return datatables()->of($data)->make(true);
    }

    public function getById($id)
    {
        try {
            $data = Permintaan::find($id);
            return response()->json($data);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json($th);
        }
    }

    public function getAllApprove()
    {
        $data = Permintaan::with(['approval'=>function ($q)
        {
            $q->selectRaw('*')->where('nip', Auth::user()->nip)->get();
        }])->whereRelation('approval','nip',Auth::user()->nip)->orderBy('tanggal', 'desc')->get();
        
        return datatables()->of($data)->make(true);
    }

    public function getJumlahBelumApprove()
    {
        $data = Permintaan::with(['approval'=>function ($q)
        {
            $q->selectRaw('*')->where('nip', Auth::user()->nip)->get();
        }])->whereRelation('approval',[['nip',Auth::user()->nip], ['status_approve', '0']])->get();
        
        $jumlah = 0;

        foreach ($data as $key => $d) {
            $status_approval = $d->status_approval;
            $urutan = $d->approval[0]->urutan;
            
            if($status_approval == $urutan){
                $jumlah =+ 1;
            }
        }

        return $jumlah;
    }

    public function create()
    {
        $response = Http::get('http://localhost:8082/hr-rmk2/public/api/karyawan/all/data');
        $datakaryawan = json_decode($response);

        $item = Item::all();

        $data = Permintaan::orderBy('created_at', 'desc')->whereYear('tanggal', date("Y"))->get();
        $count = $data->count();

        // 0001/IT/MUSI2/III/2022
        // 0001(No Dokumen) - IT(Dept_IT) - MUSI2(SITE) - III(BULAN) - 2022(TAHUN)
        $bulanromawi = ['','I','II','III','IV','V','VI','VII','VIII','IX','X','XI','XII'];
        $date = date("m");

        $dept = "IT";
        $site = "MUSI2";
        $bln = $bulanromawi[str_replace("0", "", $date)];
        $thn = date("Y");

        if(intval($count) < 1){
            $nomor_urut = "1";
        }else{
            $d = explode('/',$data->first()->ro_no);
            if($d[4] != $thn){
                $nomor_urut = "1";
            }else{
                $nomor_urut = intval($d[0]) + 1;
            }

        }

        $ceklength = strlen($nomor_urut);

        if($ceklength == '1'){
            $zero = "000";
        }else if($ceklength == '2'){
            $zero = "00";
        }else if($ceklength == '3'){
            $zero = "0";
        }else if($ceklength == '4'){
            $zero = "";
        }
        $ro = $zero."".$nomor_urut."/".$dept."/".$site."/".$bln."/".$thn;
        $satuan = Satuan::all();
        return view('admin.permintaan.tambah',compact(['satuan','ro','datakaryawan','item']));
    }

    public function store(Request $request)
    {
        try {
            $count = count($request->partname);
            // save data permintaan
            $permintaan = Permintaan::create([
                'ro_no'=>$request->no_ro,
                'nama_perusahaan'=>$request->nama_perusahaan,
                'tanggal'=>date("Y-m-d", strtotime($request->tanggal)),
                'tanggal_butuh'=>date("Y-m-d", strtotime($request->tanggal_butuh)),
                'lokasi_kerja'=>$request->lokasi_kerja,
                'status_urgent'=>$request->status_urgent,
                'status_approval'=>1,
                'status_permintaan'=>0,
            ]);

            $array = array();
            foreach ($request->nip_approver as $key => $value) {
                array_push($array, ['dokumen_id'=>$permintaan->id, 'jenis_dokumen'=>'PERMINTAAN', 'nip'=>$value, 'urutan'=>($key+1), 'status_approve'=>'0' ,'waktu_approve'=>date("Y-m-d H:i:s")]);
            }

            // save data approver di table approval
            Approval::insert($array);

            //save item permintaan
            for ($i=0; $i < $count; $i++) { 
                ItemPermintaan::create([
                    'ro_no'=>$request->no_ro,
                    'part_name'=>$request->partname[$i],
                    'part_number'=>$request->partnumber[$i],
                    'sap_item_number'=>$request->sap_item_number[$i],
                    'component'=>$request->component[$i],
                    'qty_request'=>$request->qty_request[$i],
                    'qty_request_mr'=>$request->qty_req_to_mr[$i],
                    'uom'=>$request->uom[$i],
                    'remarks'=>$request->remark[$i],
                ]);
                
            }

            return redirect()->route('permintaan.tambah')->with(['status'=>'Data berhasil disimpan!', 'code'=>201]);
            
        } catch (\Throwable $th) {
            
            return back()->with(['status'=>'Data gagal disimpan!','code'=>422]);
        }
    }

    public function edit($id)
    {
        $satuan = Satuan::all();
        $data = Permintaan::with(['item_permintaan'])->find($id);
        return view('admin.permintaan.edit', compact(['satuan','data']));
    }

    public function update(Request $request)
    {
        try {
            $data = Permintaan::find($request->id);
            $data->update(array_merge($request->except(['table-permintaan-aset_length','_token','id','tanggal','tanggal_butuh']), ['tanggal'=>date("Y-m-d", strtotime($request->tanggal)), 'tanggal_butuh'=>date("Y-m-d", strtotime($request->tanggal_butuh))]));
            if($data->status_approval != '1'){
                //hapus pdf jika sebelumnya ada
                $path = "assets/pdf/permintaan"."/".$data->pdf;
                File::delete($path);

                //save pdf baru
                $this->generatePDF($data->id);
            }
            return back()->with(['status'=>'Data berhasil diubah!','code'=>201]);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th);
            return back()->with(['status'=>'Data gagal diubah!','code'=>422]);
        }
    }

    public function updatestatusapprove(Request $request)
    {

        try {
            $dokumen = Permintaan::where('ro_no', $request->ro)->first();
            $approvalcount = Approval::where('dokumen_id', $dokumen->id)->orderBy('urutan','desc')->first();
            // 1.ubah status_approve dan waktu_approve di table approval
            Approval::where('dokumen_id', $dokumen->id)->where('nip', $request->nip)->update([
                'status_approve'=>'1',
                'waktu_approve'=>date("Y-m-d H:i:s"),
            ]);

            // 2.ubah status_approve di table permintaan
            if((intval($approvalcount->urutan)) - (intval($dokumen->status_approval)) == 1){
                $status_permintaan = '1';
            }else{
                $status_permintaan = '0';
            }

            Permintaan::where('ro_no',$request->ro)->update([
                'status_approval' => intval($dokumen->status_approval) + 1,
                // 'status_permintaan' => $status_permintaan,
            ]);

            // update pdf
                if ($dokumen->pdf != '-') {
                    //hapus pdf jika sebelumnya ada
                    $path = "assets/pdf/permintaan"."/".$dokumen->pdf;
                    File::delete($path);

                    //save pdf baru
                    $this->generatePDF($dokumen->id);
                }else{
                    // save pdf
                    $this->generatePDF($dokumen->id);
                }

            
            return response()->json(['text'=>'Data berhasil diapprove!', 'status'=>200]);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th);
        }

    }

    public function updatestatuspermintaan($ro, $status)
    {
        try {
            Permintaan::where('ro_no', str_replace('-', '/',$ro))->get();
            ItemPermintaan::where('ro_no', str_replace('-', '/',$ro))->update(['status_item_permintaan'=>$status]);
            return response()->json(['text'=>'Permintaan Telah Selesai!', 'status'=>200]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['text'=>'Item gagal diubah!', 'status'=>422]);
        }
    }

    public function excelItem($ro_no)
    {
        $ro = str_replace('-','/',$ro_no);
        $dataip = ItemPermintaan::where('ro_no',$ro)->get();
        return Excel::download(new ItemPermintaanExport($dataip), 'Item-Permintaan-'.$ro_no.'.xlsx');

    }

    public function pdf($id)
    {
        $data = Permintaan::with(['approval'])->find($id);
        $item_permintaan = ItemPermintaan::with(['satuan'])->where('ro_no',$data->ro_no)->get();
        $no_dokumen = $data->ro_no;

        $approve = array();

        foreach ($data->approval as $key => $value) {
            $response = Http::get('http://localhost:8082/hr-rmk2/public/api/karyawan/'.$value->nip);
            $dk = json_decode($response)[0];
            
            $image = QrCode::format('png')
            ->merge('assets/images/LOGO-RMKE.jpg', .3, true)
            ->size(1000)->errorCorrection('H')
            ->generate("PT RMK ENERGY TBK \n DEPARTEMEN IT \n No. Dokumen : ".$no_dokumen."\n Signed by : ".$dk->nama." - ".$dk->nip." - ".$dk->jabatan->jabatan."\n Date : ".TanggalIndo::tanggal_indo(date("Y-m-d", strtotime($value->waktu_approve))));
            $qrcode = base64_encode($image);
            
            array_push($approve, ['nip'=>$dk->nip, 'nama'=>$dk->nama, 'jabatan'=>$dk->jabatan->jabatan, 'qrcode'=>$qrcode]);
        }

        $pdf = PDF::loadView('admin.permintaan.export.pdf', compact(['data','item_permintaan','approve']))->setPaper('a4', 'potrait')->setWarnings(false);
        return $pdf->stream();
    }

    public function generatePDF($id)
    {
        $data = Permintaan::with(['approval'])->find($id);
        $item_permintaan = ItemPermintaan::with(['satuan'])->where('ro_no',$data->ro_no)->get();
        $no_dokumen = $data->ro_no;

        $approve = array();

        foreach ($data->approval as $key => $value) {
            $response = Http::get('http://localhost:8082/hr-rmk2/public/api/karyawan/'.$value->nip);
            $dk = json_decode($response)[0];
            
            $image = QrCode::format('png')
            ->merge('assets/images/LOGO-RMKE.jpg', .3, true)
            ->size(1000)->errorCorrection('H')
            ->generate("PT RMK ENERGY TBK \n DEPARTEMEN IT \n No. Dokumen : ".$no_dokumen."\n Signed by : ".$dk->nama." - ".$dk->nip." - ".$dk->jabatan->jabatan."\n Date : ".TanggalIndo::tanggal_indo(date("Y-m-d", strtotime($value->waktu_approve))));
            $qrcode = base64_encode($image);
            
            array_push($approve, ['nip'=>$dk->nip, 'nama'=>$dk->nama, 'jabatan'=>$dk->jabatan->jabatan, 'qrcode'=>$qrcode]);
        }

        $pdf = PDF::loadView('admin.permintaan.export.pdf', compact(['data','item_permintaan','approve']))->setPaper('a4', 'potrait')->setWarnings(false);
        
        $fileName = $data->id ."_". date('dmYHis') .".pdf";
        $path = "assets/pdf/permintaan"."/".$fileName;
        $pdf->save($path);

        $data->update([
            'pdf'=>$fileName
        ]);

    }

    public function laporanpdf(Request $request)
    {
        $tglawal = date("Y-m-d", strtotime($request->tanggal_awal));
        $tglakhir = date("Y-m-d", strtotime($request->tanggal_akhir));
        $datatemp = Permintaan::with(['item_permintaan','item_permintaan.satuan'])->whereBetween('tanggal', [$tglawal, $tglakhir]);
        if ($request->jenis_laporan != '4') {
            $datatemp = $datatemp->where('status_permintaan',$request->jenis_laporan);
        }
        $datatemp = $datatemp->get();

        $pdf = PDF::loadView('admin.laporan.material-request.export.pdf', compact(['datatemp','tglawal','tglakhir']))->setPaper('a4', 'potrait')->setWarnings(false);
        return $pdf->stream();
    }

    public function laporanexcel(Request $request)
    {
        $tglawal = date("Y-m-d", strtotime($request->tanggal_awal));
        $tglakhir = date("Y-m-d", strtotime($request->tanggal_akhir));
        $datatemp = Permintaan::with(['item_permintaan','item_permintaan.satuan'])->whereBetween('tanggal', [$tglawal, $tglakhir]);
        if ($request->jenis_laporan != '4') {
            $datatemp = $datatemp->where('status_permintaan',$request->jenis_laporan);
        }
        $datatemp = $datatemp->get();

        return Excel::download(new MaterialRequestExcel($datatemp, $tglawal, $tglakhir), 'Material-Request.xlsx');
        // $pdf = PDF::loadView('admin.laporan.material-request.export.pdf', compact(['datatemp','tglawal','tglakhir']))->setPaper('a4', 'potrait')->setWarnings(false);
        // return $pdf->stream();
    }

    public function laporan()
    {
        return view('admin.laporan.material-request.material-request');
    }

    public function checklaporan(Request $request)
    {
        // jenis laporan = 0-process, 4-semua, 1-complete, 3-incomplete, 2-pending
        // status permintaan = 0-process, 1-complete, 2-pending, 3-incomplete, 4-semua
        $tglawal = date("Y-m-d", strtotime($request->tanggal_awal));
        $tglakhir = date("Y-m-d", strtotime($request->tanggal_akhir));
        $datatemp = Permintaan::with(['item_permintaan'=>function ($q)
        {
            $q->selectRaw('*, count(*) as jumlah')->groupBy('ro_no')->get();
        }])->whereBetween('tanggal', [$tglawal, $tglakhir]);

        if ($request->jenis_laporan != '4') {
            $datatemp = $datatemp->where('status_permintaan',$request->jenis_laporan);
        }
        $datatemp = $datatemp->get();
        if($datatemp->count() != '0'){
            return response()->json(['status'=>200]);
        }else{
            return response()->json(['text'=>'Silahkan pilih tanggal yang sesuai!','status'=>422]);
        }
    }

    public function datalaporan($jenis_laporan, $tgl_awal, $tgl_akhir)
    {
        // jenis laporan = 0-process, 4-semua, 1-complete, 3-incomplete, 2-pending
        // status permintaan = 0-process, 1-complete, 2-pending, 3-incomplete, 4-semua
        $tglawal = date("Y-m-d", strtotime($tgl_awal));
        $tglakhir = date("Y-m-d", strtotime($tgl_akhir));
        $datatemp = Permintaan::with(['item_permintaan'=>function ($q)
        {
            $q->selectRaw('*, count(*) as jumlah')->groupBy('ro_no')->get();
        }])->whereBetween('tanggal', [$tglawal, $tglakhir]);

        if ($jenis_laporan != '4') {
            $datatemp = $datatemp->where('status_permintaan',$jenis_laporan);
        }
        $datatemp = $datatemp->get();
        return datatables()->of($datatemp)->make(true);
    }

    public function destroy($id)
    {
        $ro = Permintaan::find($id);
        try {
            // table approval
                Approval::where('dokumen_id',$id)->where('jenis_dokumen','PERMINTAAN')->delete();
            // table item permintaan
                ItemPermintaan::where('ro_no', $ro->ro_no)->delete();
            //table permintaan
                $data = Permintaan::find($id);
                $path = "assets/pdf/permintaan"."/".$data->pdf;
                File::delete($path);
                $data->delete();

                return response()->json(['text'=>'Data berhasil dihapus!', 'status'=>200]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['text'=>'Data gagal dihapus!', 'status'=>422]);
        }
    }
}
