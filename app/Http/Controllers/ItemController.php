<?php

namespace App\Http\Controllers;

use App\Exports\ItemByKategoriExport;
use App\Exports\LaptopExport;
use App\Exports\NDExport;
use App\Exports\PCExport;
use App\Exports\PrinterExport;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\ItemKeluar;
use App\Models\Kategori;
use App\Models\Satuan;
use App\Models\ItemMasuk;
use App\Models\ItemPerbaikan;
use App\Models\Kerusakan;
use App\Models\NetworkDevice;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class ItemController extends Controller
{
    public function index()
    {
        $satuan = Satuan::all();
        $kategori = Kategori::all();
        return view('admin.item.index', compact(['satuan','kategori']));
    }

    public function getAll()
    {
        $data = Item::with(['kategori','satuan'])->get();
        return datatables()->of($data)->make(true);
    }

    public function riwayatkode($id)
    {
        $item = Item::find($id);
        $kode_item = $item->kode_item;
        $kode = str_replace('-','/',$kode_item);

        $data = array();
        $temp = [];
        $final = array(); 
        if($item->kategori_id != '4'){

            $masuk = ItemMasuk::where('kode_item',$kode)->get();
            $keluar = ItemKeluar::where('kode_item',$kode)->get();
            // $kerusakan = Kerusakan::where('kode_item',$kode)->get();
            // $perbaikan = ItemPerbaikan::where('kode_item',$kode)->get();
    
            foreach ($masuk as $key => $m) {
                if($m->nip != null){
                    $jenis = "DIKEMBALIKAN";
                }else{
                    $jenis = "DITERIMA";
                }
                array_push($data, ['kode_item'=>$m->kode_item, 'tanggal'=>$m->tanggal, 'jumlah'=>$m->jumlah, 'jenis'=>$jenis, 'nip'=>$m->nip, 'deskripsi'=>$m->deskripsi, 'created_at'=>$m->created_at]);
            }
            foreach ($keluar as $key => $k) {
                array_push($data, ['kode_item'=>$k->kode_item, 'tanggal'=>$k->tanggal, 'jumlah'=>'-', 'jenis'=>'DISERAHKAN', 'nip'=>$k->nip, 'deskripsi'=>$k->deskripsi, 'created_at'=>$k->created_at]);
            }
            // foreach ($kerusakan as $key => $kr) {
            //     array_push($data, ['kode_item'=>$kr->kode_item, 'tanggal'=>$kr->tanggal, 'jumlah'=>'-', 'jenis'=>'KERUSAKAN', 'nip'=>$kr->nip, 'deskripsi'=>$kr->deskripsi, 'created_at'=>$kr->created_at]);
            // }
            // foreach ($perbaikan as $key => $p) {
            //     array_push($data, ['kode_item'=>$p->kode_item, 'tanggal'=>$p->tanggal_perbaikan, 'jumlah'=>'-', 'jenis'=>'PERBAIKAN', 'nip'=>$p->nip, 'deskripsi'=>$p->deskripsi, 'created_at'=>$p->created_at]);
            // }
    
            foreach ($data as $key => $v) {
                $temp['kode_item'] = $v['kode_item'];
                $temp['tanggal'] = $v['tanggal'];
                $temp['jenis'] = $v['jenis'];
                $temp['jumlah'] = $v['jumlah'];
    
                if($v['nip'] != null){
                    $response = Http::get('http://localhost:8082/hr-rmk2/public/api/karyawan/'.$v['nip']);
                    $datakaryawan = json_decode($response)[0];
                    $temp['nip'] = $datakaryawan->nip;
                    $temp['user'] = $datakaryawan->nama;
                    $temp['jabatan'] = $datakaryawan->jabatan->jabatan;
                }else{
                    $temp['nip'] = '-';
                    $temp['user'] = '-';
                    $temp['jabatan'] = '-';
                }
                $temp['deskripsi'] = $v['deskripsi'];
     
                array_push($final, $temp);
            }
            return datatables()->of($final)->make(true);

        }else{

            $networkdevice = NetworkDevice::with(['lokasi_network_device'])->where('kode_item', $kode_item)->get();
            return datatables()->of($networkdevice)->make(true);
        }


        // return view('admin.item.riwayat-kodeaset', compact(['data']));
    }

    public function getRiwayatService($id)
    {
        $item = Item::find($id);
        $kode_item = $item->kode_item;
        $kode = str_replace('-','/',$kode_item);

        $data = array();
        $temp = [];
        $final = array(); 
        if($item->kategori_id != '4'){

            // $masuk = ItemMasuk::where('kode_item',$kode)->get();
            // $keluar = ItemKeluar::where('kode_item',$kode)->get();
            $kerusakan = Kerusakan::where('kode_item',$kode)->get();
            $perbaikan = ItemPerbaikan::where('kode_item',$kode)->get();
    
            // foreach ($masuk as $key => $m) {
            //     if($m->nip != null){
            //         $jenis = "DIKEMBALIKAN";
            //     }else{
            //         $jenis = "DITERIMA";
            //     }
            //     array_push($data, ['kode_item'=>$m->kode_item, 'tanggal'=>$m->tanggal, 'jumlah'=>$m->jumlah, 'jenis'=>$jenis, 'nip'=>$m->nip, 'deskripsi'=>$m->deskripsi, 'created_at'=>$m->created_at]);
            // }
            // foreach ($keluar as $key => $k) {
            //     array_push($data, ['kode_item'=>$k->kode_item, 'tanggal'=>$k->tanggal, 'jumlah'=>'-', 'jenis'=>'DISERAHKAN', 'nip'=>$k->nip, 'deskripsi'=>$k->deskripsi, 'created_at'=>$k->created_at]);
            // }
            foreach ($kerusakan as $key => $kr) {
                array_push($data, ['kode_item'=>$kr->kode_item, 'tanggal'=>$kr->tanggal, 'jumlah'=>'-', 'jenis'=>'KERUSAKAN', 'nip'=>$kr->nip, 'deskripsi'=>$kr->deskripsi, 'created_at'=>$kr->created_at]);
            }
            foreach ($perbaikan as $key => $p) {
                array_push($data, ['kode_item'=>$p->kode_item, 'tanggal'=>$p->tanggal_perbaikan, 'jumlah'=>'-', 'jenis'=>'PERBAIKAN', 'nip'=>$p->nip, 'deskripsi'=>$p->deskripsi, 'created_at'=>$p->created_at]);
            }
    
            foreach ($data as $key => $v) {
                $temp['kode_item'] = $v['kode_item'];
                $temp['tanggal'] = $v['tanggal'];
                $temp['jenis'] = $v['jenis'];
                $temp['jumlah'] = $v['jumlah'];
    
                if($v['nip'] != null){
                    $response = Http::get('http://localhost:8082/hr-rmk2/public/api/karyawan/'.$v['nip']);
                    $datakaryawan = json_decode($response)[0];
                    $temp['nip'] = $datakaryawan->nip;
                    $temp['user'] = $datakaryawan->nama;
                    $temp['jabatan'] = $datakaryawan->jabatan->jabatan;
                }else{
                    $temp['nip'] = '-';
                    $temp['user'] = '-';
                    $temp['jabatan'] = '-';
                }
                $temp['deskripsi'] = $v['deskripsi'];
     
                array_push($final, $temp);
            }
            return datatables()->of($final)->make(true);

        }else{

            $networkdevice = NetworkDevice::with(['lokasi_network_device'])->where('kode_item', $kode_item)->get();
            return datatables()->of($networkdevice)->make(true);
        }
    }

    public function getRiwayatItemService($id)
    {
        $item = Item::find($id);
        $kode_item = $item->kode_item;

        $item = ItemKeluar::with(['item','item_service','item_service.item_perbaikan'])->whereRelation('item','kategori_id','6')->whereRelation('item_service.item_perbaikan','kode_item',$kode_item)->get();
        $data = array();
        foreach ($item as $key => $i) {
            array_push($data, ['kode_item'=>$i->kode_item, 'merk'=>$i->item->merk,  'nip'=>$i->nip, 'nama'=>$i->item->nama_item, 'jumlah'=>$i->item_service[0]->jumlah, 'kode_item_perbaikan'=>$i->item_service[0]->item_perbaikan->kode_item]);
        }

        $temp = [];
        $final = array(); 

        foreach ($data as $key => $v) {
            $temp['kode_item'] = $v['kode_item'];
            $temp['nama'] = $v['nama'];
            $temp['merk'] = $v['merk'];
            $temp['jumlah'] = $v['jumlah'];

            if($v['nip'] != null){
                $response = Http::get('http://localhost:8082/hr-rmk2/public/api/karyawan/'.$v['nip']);
                $datakaryawan = json_decode($response)[0];
                $temp['nip'] = $datakaryawan->nip;
                $temp['user'] = $datakaryawan->nama;
                $temp['jabatan'] = $datakaryawan->jabatan->jabatan;
            }else{
                $temp['nip'] = '-';
                $temp['user'] = '-';
                $temp['jabatan'] = '-';
            }
 
            array_push($final, $temp);
        }
        
        return datatables()->of($final)->make(true);

    }

    public function riwayatnip($nip)
    {
        $data = array();
        
        $masuk = ItemMasuk::where('nip',$nip)->get();
        $keluar = ItemKeluar::where('nip',$nip)->get();
        $kerusakan = Kerusakan::where('nip',$nip)->get();
        $perbaikan = ItemPerbaikan::where('nip',$nip)->get();
        
        foreach ($masuk as $key => $m) {
            array_push($data, ['kode_item'=>$m->kode_item, 'tanggal'=>$m->tanggal, 'jenis'=>'MASUK', 'nip'=>$m->nip]);
        }
        foreach ($keluar as $key => $k) {
            array_push($data, ['kode_item'=>$k->kode_item, 'tanggal'=>$k->tanggal, 'jenis'=>'KELUAR', 'nip'=>$k->nip]);
        }
        foreach ($kerusakan as $key => $kr) {
            array_push($data, ['kode_item'=>$kr->kode_item, 'tanggal'=>$kr->tanggal, 'jenis'=>'KERUSAKAN', 'nip'=>$kr->nip]);
        }
        foreach ($perbaikan as $key => $p) {
            array_push($data, ['kode_item'=>$p->kode_item, 'tanggal'=>$p->tanggal_perbaikan, 'jenis'=>'UPGRADE', 'nip'=>$p->nip]);
        }

        return view('admin.item.riwayat-kodenip', compact(['data']));
    }

    public function kodeItem()
    {
        //generate kode item
        $kode = Item::where('kode_item','!=','-')->orderBy('kode_item', 'desc')->first();
        if(!$kode){
            $k = 1;
        }else{
            $k = ($kode->kode_item +1);
        }
        return response()->json($k);
    }

    public function itembykode($kode)
    {
        $kode_item = str_replace('-','/',$kode);
        $data = Item::with(['kategori'])->where('kode_item', $kode_item)->first();
        return response()->json($data);
    }

    public function itembyid($id)
    {
        $data = Item::with(['kategori'])->where('id', $id)->first();
        return response()->json($data);
    }

    public function edit($id)
    {
        $data = Item::find($id);
        $satuan = Satuan::all();
        $kategori = Kategori::all();
        $jenis = $data->kategori_id;
        if($jenis == '4'){
            return view('admin.item.edit-network-device', compact(['data','satuan','kategori','jenis']));
        }else{
            return view('admin.item.edit', compact(['data','satuan','kategori','jenis']));
        }
    }

    public function store(Request $request)
    {
        //generate kode item
        if ($request->kategori_id == '6') {
            $no = Item::where('kategori_id','6')->orderBy('created_at', 'desc')->first();
        }else{
            $no = Item::where('kategori_id','!=','6')->orderBy('created_at', 'desc')->first();
        }
        if(!$no){
            $k = 1;
        }else{
            $ktemp = explode("/",$no->kode_item);
            $k = (intval($ktemp[0]) +1);
        }
        $jenis = Kategori::find($request->kategori_id)->kode;
        $kode = $k."/".$jenis."/"."IT"."/".date("Y");

        $cekkode = Item::where('kode_item', $kode)->count();
        
        if($cekkode != '0'){
            return response()->json(['text'=>'Kode Aset sudah ada!', 'status'=>422]);
        }
        // $data = $request->all();
        // $data['kode_item'] = $kode;
        // $data['status_fisik']=1; //1=baik, 2=rusak
        // $data['status_item']=1; //1=ready, 2=not available, 3=request

        //simpan data 
        try {

            if($request->kategori_id == '6'){
                    if ($request->select_jenis_item == '2') {
                        $item = Item::where('kode_item',$request->kode_item);
                        $item->update(['jumlah' => (($item->first()->jumlah) + ($request->jumlah))]);
                        $kode = $request->kode_item;
                    }else{
                        Item::create(array_merge($request->except(['_token','tanggal_item','nama_item','serie_item','merk','deskripsi','select_jenis_item']), ['nama_item'=>strtoupper($request->nama_item),'serie_item'=>strtoupper($request->serie_item),'merk'=>strtoupper($request->merk),'deskripsi'=>strtoupper($request->deskripsi),'kode_item'=>$kode, 'tanggal'=>date("Y-m-d", strtotime($request->tanggal_item)) ,'status_fisik'=>1, 'status_item'=>1]));
                    }
            }else{
                // table item , status_fisik (kondisi) = 1=baik, 2=rusak, 3=perbaikan
                Item::create(array_merge($request->except(['_token','tanggal_item','nama_item','serie_item','merk','deskripsi']), ['nama_item'=>strtoupper($request->nama_item),'serie_item'=>strtoupper($request->serie_item),'merk'=>strtoupper($request->merk),'deskripsi'=>strtoupper($request->deskripsi),'kode_item'=>$kode, 'tanggal'=>date("Y-m-d", strtotime($request->tanggal_item)) ,'status_fisik'=>1, 'status_item'=>1,'jumlah'=>1]));
            }

            $jumlah = 0;

            if(isset($request->jumlah)){
                $jumlah = $request->jumlah;
            }else{
                $jumlah = 1;
            }
            // table item_masuk
            ItemMasuk::create([
                'kode_item' => $kode,
                'tanggal'=> date("Y-m-d", strtotime($request->tanggal_item)),
                'status_item' => '1', //1=baik , 2=rusak
                'type'=>1, //1=barang baru, 2=pengembalian
                'jumlah'=>$jumlah,
                'deskripsi'=>$request->keterangan,
            ]);

            $kategori = Kategori::find($request->kategori_id)->kategori;
            return response()->json(['text'=>'Item berhasil ditambahkan!', 'status'=>201, 'kategori'=>$kategori]);
        } catch (\Throwable $th) {
            dd($th);
            return response()->json(['text'=>'Item gagal ditambahkan!', 'status'=>422]);
        }

    }

    public function update(Request $request)
    {
        try {
            // table item
            Item::find($request->id)->update(array_merge($request->except(['_token','id','tanggal','nama_item','serie_item','merk','deskripsi']), ['nama_item'=>strtoupper($request->nama_item),'serie_item'=>strtoupper($request->serie_item),'merk'=>strtoupper($request->merk),'deskripsi'=>strtoupper($request->deskripsi),'tanggal'=>date("Y-m-d", strtotime($request->tanggal))]));


            // table item_masuk
            // dd(Item::find($request->id)->kategori_id);
            // 1=laptop, 2=printer, 3=pc, 4=network_device, 5=peripherals, 6=consumable
            $kategori = Kategori::find($request->kategori_id)->kategori;
            
            return response()->json(['text'=>'Item berhasil ditambahkan!', 'status'=>200, 'kategori'=>strtolower($kategori)]);
        } catch (\Throwable $th) {
            return response()->json(['text'=>'Item gagal ditambahkan!', 'status'=>422]);
        }
    }
    
    public function destroy(Request $request)
    {
        try {
            $item = Item::find($request->id);
            $kode_item = $item->kode_item;
            
            ItemMasuk::where('kode_item', $kode_item)->delete();
            ItemKeluar::where('kode_item', $kode_item)->delete();
            
            $item->delete();

            return response()->json(['text'=>'Item berhasil dihapus!', 'status'=>200]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['text'=>'Item gagal dihapus!', 'status'=>422]);
        }
    }

    public function laptop()
    {
        $satuan = Satuan::all();
        $kategori = Kategori::all();
        return view('admin.item.laptop.index', compact(['satuan','kategori']));
    }

    public function datalaptop()
    {
        $data = Item::with(['kategori','satuan'])->where('kategori_id',1)->orderBy('created_at', 'desc')->get();
        return datatables()->of($data)->make(true);
    }

    public function printer()
    {
        $satuan = Satuan::all();
        $kategori = Kategori::all();
        return view('admin.item.printer.index', compact(['satuan','kategori']));
    }

    public function dataprinter()
    {
        $data = Item::with(['kategori','satuan'])->where('kategori_id',2)->orderBy('created_at', 'desc')->get();
        return datatables()->of($data)->make(true);
    }
    
    public function pc()
    {
        $satuan = Satuan::all();
        $kategori = Kategori::all();
        return view('admin.item.pc.index', compact(['satuan','kategori']));
    }

    public function datapc()
    {
        $data = Item::with(['kategori','satuan'])->where('kategori_id',3)->orderBy('created_at', 'desc')->get();
        return datatables()->of($data)->make(true);
    }

    public function networkDevice()
    {
        $satuan = Satuan::all();
        $kategori = Kategori::all();
        return view('admin.item.networkdevice.index', compact(['satuan','kategori']));
    }

    public function datanetworkDevice()
    {
        $data = Item::with(['kategori','satuan'])->where('kategori_id',4)->orderBy('created_at', 'desc')->get();
        return datatables()->of($data)->make(true);
    }

    public function peripheral()
    {
        $satuan = Satuan::all();
        $kategori = Kategori::all();
        return view('admin.item.peripheral.index', compact(['satuan','kategori']));
    }

    public function dataperipheral()
    {
        $data = Item::with(['kategori','satuan'])->where('kategori_id',5)->orderBy('created_at', 'desc')->get();
        return datatables()->of($data)->make(true);
    }

    public function consumable()
    {
        $satuan = Satuan::all();
        $kategori = Kategori::all();
        $itemconsumable = Item::where('kategori_id','6')->get();
        return view('admin.item.consumable.index', compact(['satuan','kategori','itemconsumable']));
    }

    public function dataconsumable($status)
    {
        if($status == 1){
            $data = Item::with(['kategori','satuan'])->where('kategori_id',6)->where('status_item', 1)->where('jumlah', '!=', 0)->orderBy('created_at', 'desc')->get();
        }else if($status == 2){
            $data = Item::with(['kategori','satuan'])->where('kategori_id',6)->where('status_item', 1)->where('jumlah', '=', 0)->orderBy('created_at', 'desc')->get();
        }else{
            $data = Item::with(['kategori','satuan'])->where('kategori_id',6)->orderBy('created_at', 'desc')->get();
        }
        return datatables()->of($data)->make(true);
    }

    // function export data item kategori
    public function exportnd($jenis_export)
    {
        $data = Item::with(['kategori','network_device','network_device.lokasi_network_device','network_device.lokasi_network_device.area_lokasi_network_device'])->where('kategori_id', '4')->get();
        // $response = Http::get('http://localhost:8082/hr-rmk2/public/api/karyawan/all/data');
        // $datakaryawan = json_decode($response)->data;
        $final = array();
        $temp = [];

        foreach ($data as $key => $value) {
            $temp['kode_item'] = $value->kode_item;
            $temp['kategori'] = $value->kategori->kategori;
            $temp['nama'] = $value->nama_item;
            $temp['serie'] = $value->serie_item;
            $temp['merk'] = $value->merk;
            $temp['kondisi'] = $value->status_fisik;
            $temp['status'] = $value->status_item;
            
            //cek apakah item digunakan
            if($value->status_item != '1'){
                $temp['ip'] = $value->network_device->ip;
                $temp['lokasi'] = $value->network_device->lokasi_network_device->nama_lokasi;
                $temp['area'] = $value->network_device->lokasi_network_device->area_lokasi_network_device->nama_area_lokasi;

            }else{
                $temp['ip'] = '-';
                $temp['lokasi'] = '-';
                $temp['area'] = '-';

            }

            array_push($final, $temp);

        }
        $datafinal = collect($final)->groupBy('area');

        if ($jenis_export == '1') {
            // excel
            return Excel::download(new NDExport($datafinal), 'NetworkDevice.xlsx');
        }else if($jenis_export == '2'){
            //pdf
            $pdf = PDF::loadView('admin.item.export.network-device-pdf', compact(['datafinal']))->setPaper('a4', 'potrait')->setWarnings(false);
            return $pdf->stream();
        }

    }

    public function exportitembykategori($kategori_id, $jenis_export)
    {
        $data = Item::with(['kategori'])->where('kategori_id', $kategori_id)->get();
        $response = Http::get('http://localhost:8082/hr-rmk2/public/api/karyawan/all/data');
        $datakaryawan = json_decode($response);
        $final = array();
        $temp = [];

        $kategori = Kategori::find($kategori_id)->kategori;

        foreach ($data as $key => $value) {
            $temp['kode_item'] = $value->kode_item;
            $temp['kategori'] = $value->kategori->kategori;
            $temp['nama'] = $value->nama_item;
            $temp['serie'] = $value->serie_item;
            $temp['merk'] = $value->merk;
            $temp['kondisi'] = $value->status_fisik;
            $temp['status'] = $value->status_item;
            
            //cek apakah item digunakan
            if($value->status_item != '1'){
                $nip = ItemKeluar::where('kode_item', $value->kode_item)->orderBy('created_at','desc')->first();

                foreach($datakaryawan as $dk) {
                    if ($nip->nip == $dk->nip) {
                        $temp['user'] = $dk->nama;
                        $temp['jabatan'] = $dk->jabatan->jabatan;
                        break;
                    }
                }

            }else{
                $temp['user'] = '-';
                $temp['jabatan'] = '-';
            }
            array_push($final, $temp);
        }

        $datafinal = collect($final)->groupBy('status');

        if($jenis_export == '1'){
            //excel
            return Excel::download(new ItemByKategoriExport($datafinal), 'item.xlsx');
        }else if($jenis_export == '2'){
            //pdf
            $pdf = PDF::loadView('admin.item.export.laptop-pdf', compact(['datafinal','kategori']))->setPaper('a4', 'potrait')->setWarnings(false);
            return $pdf->stream();
        }
    }

}
