<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemKeluar;
use App\Models\ItemMasuk;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use PDF;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Helpers\TanggalIndo;
use DateTime;
use DateTimeZone;
use Intervention\Image\Facades\Image;
use Auth;

class ItemMasukController extends Controller
{
    public function index()
    {
        // ambil item yg ready
        $item = Item::where('site', Auth::user()->lokasi)->get();
        $itemconsumable = Item::where('kategori_id','6')->get();
        // $item = Item::where('status_item',2)->get();
        $item1 = Item::where('site', Auth::user()->lokasi)->where('status_item',1)->get();
        $itemedit = Item::where('site', Auth::user()->lokasi)->where('site', Auth::user()->lokasi)->get();
        $response = Http::get('http://localhost:8082/hr-rmk2/public/api/karyawan/all/data');
        $datakaryawan = json_decode($response);
        $response1 = Http::get('http://localhost:8082/hr-rmk2/public/api/karyawan/departemen/25');
        $datakaryawanit = json_decode($response1);
        return view('admin.inventaris.masuk.index', compact(['datakaryawanit','item','item1','datakaryawan', 'itemedit','itemconsumable',]));
    }

    public function getAll()
    {
        $data = ItemMasuk::with(['kategori','satuan','item'])->whereRelation('item', 'site', Auth::user()->lokasi)->get();
        return datatables()->of($data)->make(true);
    }

    public function getItemKeluar(Request $r)
    {
        $data = ItemKeluar::where('kode_item',$r->kode)->orderBy('updated_at','desc')->first();
        $response = Http::get('http://localhost:8082/hr-rmk2/public/api/karyawan/'.$data->nip);
        $data = json_decode($response)[0];
        return response()->json($data);
    }

    public function all()
    {
        // $itemmasuk = ItemMasuk::with(['item'=>function ($query)
        // {
        //     $query->select('*');
        // },
        // 'item.kategori'=>function ($query)
        // {
        //     $query->select('*');
        // }
        // ])->where('type','2')->orderBy('tanggal', 'desc')->get();

        $itemmasuk = ItemMasuk::with(['item.kategori'])->whereRelation('item','site',Auth::user()->lokasi)->where('type','2')->orderBy('tanggal', 'desc')->get();

        // $client = new \GuzzleHttp\Client();
        // $response = $client->request('GET', 'http://localhost:8082/hr-rmk2/public/api/karyawan/all/data');
        // $data = $response->getBody();
        // dd($data);

        $response = Http::get('http://localhost:8082/hr-rmk2/public/api/karyawan/all/data');

        $datakaryawan = json_decode($response);
        $result=[];
        $final = array();
        $niptemp="";

        foreach ($itemmasuk as $key => $im) {
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
            $result['gambar']=$im->gambar;
            $result['kode_item']=$im->kode_item;
            $result['status_item']=$im->status_item;
            $result['deskripsi']=$im->deskripsi;
            $result['nama_item']=$im->item->nama_item;
            $result['merk']=$im->item->merk;
            $result['serie_item']=$im->item->serie_item;
            $result['kategori']=$im->item->kategori->kategori;
            $result['status_item']=$im->item->status_item;

            array_push($final,  $result);
        }
        // return $final;
        return datatables()->of($final)->make(true);
    }

    public function store(Request $request)
    {
        $kode = "/ASET-IT/DI/".date("Y");
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

            $item = Item::where('kode_item', $request->kode_item)->first();

            if($item->kategori_id == '6'){
                
                $itemkeluar = ItemKeluar::where('kode_item', $request->kode_item)->where('nip',$request->nip);
                if($itemkeluar->count() == '0'){
                    return response()->json(['text'=>'Data tidak ditemukan!', 'status'=>422]);
                }else{
                    $itemkeluar->delete();

                    Item::where('kode_item', $request->kode_item)->update([
                        'jumlah'=>intval($item->jumlah) + 1,
                        // 'status_fisik'=>$request->status_item,
                    ]);
                }

            }else{
                
                ItemMasuk::create([
                    'kode_item'=>$request->kode_item,
                    'tanggal'=>date("Y-m-d", strtotime($request->tanggal)),
                    'nip'=>$request->nip,
                    'status_item'=>$request->status_item,
                    'deskripsi'=>$request->deskripsi,
                    'no_dokumen'=>$no,
                    'type'=>2,
                ]);

                Item::where('kode_item', $request->kode_item)->update([
                    'status_item'=>'1',
                    'status_fisik'=>$request->status_item,
                ]);

            }

            return response()->json(['text'=>'Data berhasil disimpan!', 'status'=>201]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['text'=>'Data tidak berhasil disimpan!', 'status'=>422]);
        }
    }

    public function update(Request $request)
    {
        if($request->nip == "null"){
            $r = $request->except(['_token','id','nip', 'tanggal']);
        }else{
            $r = $request->except(['_token','id', 'tanggal']);
        }

        try {
            $ik = ItemMasuk::find($request->id)->kode_item;
            Item::where('kode_item',$ik)->update([
                'status_item' => 2,
            ]);
            ItemMasuk::find($request->id)->update(array_merge($r, ['tanggal'=>date("Y-m-d", strtotime($request->tanggal))]));
            return response()->json(['text'=>'Data berhasil diubah!', 'status'=>200]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['text'=>'Data gagal diubah!', 'status'=>422]);
        }
    }

    public function uploadgambar(Request $request)
    {
        if($request->hasFile('gambar')){
            $file = $request->file('gambar')->getClientOriginalExtension();
            if($file == 'jpg' or $file == 'jpeg' or $file == 'png' or $file == 'JPG' or $file == 'JPEG' or $file == 'PNG'){
                $rand = date("Ymd_His") ."_". rand(99,99999999) . ".".$file;

                if(($request->file('gambar')->getSize() / 1024) > 60){
                    //compress file gambar
                    Image::make($request->file('gambar'))->resize(700, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->rotate(-90)->save('assets/images/device_in/'.$rand);
                }else{
                    Image::make($request->file('gambar'))->rotate(-90)->save('assets/images/device_in/'.$rand);
                }
                // $request->file('gambar')->move(public_path('/assets/images/device_out'), $rand);
                
                //simpan alamat gambar di table item_keluar
                ItemMasuk::find($request->id)->update(['gambar'=>$rand]);
                return response()->json(['text'=>'Format file Benar!', 'status'=>200]);
            }else{
                return response()->json(['text'=>'Format file salah!', 'status'=>400]);
            }
        }else{
            return response()->json(['text'=>'File tidak boleh kosong!', 'status'=>400]);
        }
    }

    public function edit($id)
    {
        return response()->json(ItemMasuk::find($id));
    }

    public function pdf(Request $request)
    {
        //nip staff it

        $date = new DateTime("now", new DateTimeZone('Asia/Jakarta') );
        $tanggalnow = TanggalIndo::tanggal_indo($date->format('Y-m-d'));
        $waktu = $date->format('H:i:s');

        $response = Http::get('http://localhost:8082/hr-rmk2/public/api/karyawan/'.$request->nip_it);
        $datakaryawan = json_decode($response)[0];
        $data = ItemMasuk::with(['item', 'item.kategori'])->find($request->id);

        $penerima = Http::get('http://localhost:8082/hr-rmk2/public/api/karyawan/'.$data->nip);
        $datapenerima = json_decode($penerima)[0];

        $tanggal = TanggalIndo::tanggal_indo($data->tanggal);

        $kode = "PT RMK ENERGY TBK \n"."No Dokumen : ".$data->no_dokumen."\nSigned By : ".$datakaryawan->nama." | ".$datakaryawan->jabatan->jabatan." | Departemen IT \n"."Date : ".$tanggalnow." ".$waktu;

        $image = QrCode::format('png')
        ->merge('assets/images/LOGO-RMKE.jpg', .3, true)
        ->size(500)->errorCorrection('H')
        ->generate($kode);
        $qrcode = base64_encode($image);

        $pdf = PDF::loadView('admin.inventaris.masuk.export.pdf', compact(['tanggal','datapenerima','data','datakaryawan','qrcode']))->setPaper('a4', 'potrait')->setWarnings(false);
        return $pdf->stream();
    }
}
