<?php

namespace App\Http\Controllers;

use App\Helpers\TanggalIndo;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\ItemKeluar;
use Illuminate\Support\Facades\Http;
use PDF;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Intervention\Image\Facades\Image;
use DateTime;
use DateTimeZone;
use File;
use Auth;

class ItemKeluarController extends Controller
{
    public function index()
    {
        //ambil item yg ready untuk diberikan ke karyawan
        $item = Item::where('site', Auth::user()->lokasi)->where('status_item',1)->get();
        $itemedit = Item::where('site', Auth::user()->lokasi)->get();
        $response = Http::get('http://localhost:8082/hr-rmk2/public/api/karyawan/all/data');
        $datakaryawan = json_decode($response);
        $response1 = Http::get('http://localhost:8082/hr-rmk2/public/api/karyawan/departemen/25');
        $datakaryawanit = json_decode($response1);
        return view('admin.inventaris.keluar.index',compact(['item','datakaryawan','itemedit','datakaryawanit']));
    }

    public function all()
    {
        $itemkeluar = ItemKeluar::with(['item.kategori'])->whereRelation('item.item_site', 'site' ,Auth::user()->lokasi)->orderBy('tanggal', 'desc')->get();

        $response = Http::get('http://localhost:8082/hr-rmk2/public/api/karyawan/all/data');
        $datakaryawan = json_decode($response);
        $result=[];
        $final = array();
        $niptemp="";

        foreach ($itemkeluar as $key => $im) {
            $niptemp = $im->nip;
            foreach ($datakaryawan as $key => $dk) {
                if($dk->nip == $niptemp){
                    $result['nama'] = $dk->nama;
                    $result['jabatan'] = $dk->jabatan->jabatan;
                    $result['departemen'] = $dk->departemen->departemen;
                    $result['area_kerja'] = $dk->area_kerja->nama_area;
                    $result['nip'] = $dk->nip;

                    break;
                }
            }
            $result['id']=$im->id;
            $result['tanggal']=$im->tanggal;
            $result['kode_item']=$im->kode_item;
            $result['gambar']=$im->gambar;
            $result['status_item']=$im->status_item;
            $result['deskripsi']=$im->deskripsi;
            $result['nama_item']=$im->item->nama_item;
            $result['merk']=$im->item->merk;
            $result['serie_item']=$im->item->serie_item;
            $result['kategori']=$im->item->kategori->kategori;
            $result['created_at']=$im->item->created_at;

            array_push($final,  $result);
        }
        return datatables()->of($final)->make(true);
    }

    public function store(Request $request)
    {

        $kode = "/ASET-IT/DO/".date("Y");
        $cek = ItemKeluar::orderBy('created_at','desc')->first()->no_dokumen;
        if($cek == '-'){
            $no = '0000'. 1 . $kode;
        }else{
            $part = explode("/", $cek);
            $nomor = intval($part[0]) + 1;
            if($nomor < 10){
                $no = '0000'. $nomor . $kode;
            }else if($nomor > 9 && $nomor < 100){
                $no = '000'. $nomor . $kode;
            }else if($nomor > 99 && $nomor < 1000){
                $no = '00'. $nomor . $kode;
            }else if($nomor > 999){
                $no = '0'. $nomor . $kode;
            }else{
                $no = $nomor . $kode;
            }
        }
        
        try {
            ItemKeluar::create(array_merge($request->except(['_token','tanggal']), ['tanggal'=>date("Y-m-d", strtotime($request->tanggal)), 'no_dokumen'=>$no]));

            $item = Item::where('kode_item', $request->kode_item)->first();
            if($item->kategori_id == "6"){
                Item::where('kode_item', $request->kode_item)->update([
                    'jumlah'=>$item->jumlah - 1,
                ]);
            }else{
                Item::where('kode_item', $request->kode_item)->update(['status_item'=>'2']);
            }

            return response()->json(['text'=>'Data berhasil disimpan!', 'status'=>201]);
        } catch (\Throwable $th) {
            dd($th);
            return response()->json(['text'=>'Data tidak berhasil disimpan!', 'status'=>422]);
        }
    }

    public function uploadgambar(Request $request)
    {
        if($request->hasFile('gambar')){
            $file = $request->file('gambar')->getClientOriginalExtension();
            if($file == 'jpg' or $file == 'jpeg' or $file == 'png' or $file == 'JPG' or $file == 'JPEG' or $file == 'PNG'){
                $rand = date("Ymd_His") ."_". rand(99,99999999) . ".".$file;

                //cek exist gambar
                $gambar = ItemKeluar::find($request->id)->gambar;
                if(File::exists(public_path('assets/images/device_out/'.$gambar))){
                    File::delete(public_path('assets/images/device_out/'.$gambar));
                }

                if(($request->file('gambar')->getSize() / 1024) > 60){
                    //compress file gambar
                    Image::make($request->file('gambar'))->resize(700, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->rotate(-90)->save('assets/images/device_out/'.$rand);
                }else{
                    Image::make($request->file('gambar'))->rotate(-90)->save('assets/images/device_out/'.$rand);
                }
                // $request->file('gambar')->move(public_path('/assets/images/device_out'), $rand);
                
                //simpan alamat gambar di table item_keluar
                ItemKeluar::find($request->id)->update(['gambar'=>$rand]);
                return response()->json(['text'=>'Format file Benar!', 'status'=>200]);
            }else{
                return response()->json(['text'=>'Format file salah!', 'status'=>400]);
            }
        }else{
            return response()->json(['text'=>'File tidak boleh kosong!', 'status'=>400]);
        }
    }

    public function pdf(Request $request)
    {
        // dd($request->all());
        //nip staff it

        $date = new DateTime("now", new DateTimeZone('Asia/Jakarta') );
        $tanggalnow = TanggalIndo::tanggal_indo($date->format('Y-m-d'));
        $waktu = $date->format('H:i:s');

        $response = Http::get('http://localhost:8082/hr-rmk2/public/api/karyawan/'.$request->nip_it);
        $datakaryawan = json_decode($response)[0];
        $data = ItemKeluar::with(['item', 'item.kategori'])->find($request->id);

        $penerima = Http::get('http://localhost:8082/hr-rmk2/public/api/karyawan/'.$data->nip);
        $datapenerima = json_decode($penerima)[0];

        $tanggal = TanggalIndo::tanggal_indo($data->tanggal);
        // $tanggal = date_format($tgl, "d F Y" );

        $kode = "PT RMK ENERGY TBK \n"."No Dokumen : ".$data->no_dokumen."\nSigned By : ".$datakaryawan->nama." | ".$datakaryawan->jabatan->jabatan." | Departemen IT \n"."Date : ".$tanggalnow." ".$waktu;

        $image = QrCode::format('png')
        ->merge('assets/images/LOGO-RMKE.jpg', .3, true)
        ->size(500)->errorCorrection('H')
        ->generate($kode);
        $qrcode = base64_encode($image);

        $pdf = PDF::loadView('admin.inventaris.keluar.export.pdf', compact(['tanggal','datapenerima','data','datakaryawan','qrcode']))->setPaper('a4', 'potrait')->setWarnings(false);
        return $pdf->stream();
    }

    public function update(Request $request)
    {
        if($request->nip == "null"){
            $r = $request->except(['_token','id','nip']);
        }else{
            $r = $request->except(['_token','id']);
        }

        try {
            $ik = ItemKeluar::find($request->id)->kode_item;
            Item::where('kode_item',$ik)->update([
                'status_item' => 1,
            ]);
            ItemKeluar::find($request->id)->update(array_merge($r,['tanggal'=>date("Y-m-d", strtotime($request->tanggal))]));
            return response()->json(['text'=>'Data berhasil diubah!', 'status'=>200]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['text'=>'Data gagal diubah!', 'status'=>422]);
        }
    }

    public function edit($id)
    {
        return response()->json(ItemKeluar::find($id));
    }

    public function deletegambar(Request $request)
    {
        try {
            $gambar = ItemKeluar::find($request->id)->gambar;
            if(File::exists(public_path('assets/images/device_out/'.$gambar))){
                File::delete(public_path('assets/images/device_out/'.$gambar));

                ItemKeluar::find($request->id)->update([
                    'gambar'=>'-'
                ]);
            }
            return response()->json(['text'=>'Gambar berhasil dihapus!', 'status'=>200]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['text'=>'Gambar gagal dihapus!', 'status'=>422]);
        }

    }
}
