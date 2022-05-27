<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemKeluar;
use App\Models\ItemMasuk;
use App\Models\ItemPerbaikan;
use App\Models\Kerusakan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Helpers\TanggalIndo;
use App\Models\Permintaan;

class AdminController extends Controller
{
    public function index()
    {
        // item->status_fisik : 1=baik, 2=rusak
        // item->status_item : //1=ready, 2=not available, 3=request
        // Kategori = ['LAPTOP','PRINTER','PC','NETWORK DEVICE','PERIPHERALS','CONSUMABLE'];

        //LAPTOP (Kategori = 1)
        $laptop_total = Item::where('kategori_id','1')->get()->count();
        $laptop_rusak = Item::where('kategori_id','1')->where('status_fisik','2')->get()->count();
        $laptop_baik = Item::where('kategori_id','1')->where('status_fisik','1')->get()->count();

        //PRINTER (Kategori = 2)
        $printer_total = Item::where('kategori_id','2')->get()->count();
        $printer_rusak = Item::where('kategori_id','2')->where('status_fisik','2')->get()->count();
        $printer_baik = Item::where('kategori_id','2')->where('status_fisik','1')->get()->count();

        //PC (Kategori = 3)
        $pc_total = Item::where('kategori_id','3')->get()->count();
        $pc_rusak = Item::where('kategori_id','3')->where('status_fisik','2')->get()->count();
        $pc_baik = Item::where('kategori_id','3')->where('status_fisik','1')->get()->count();

        //NETWORK DEVICE (Kategori = 4)
        $nd_total = Item::where('kategori_id','4')->get()->count();
        $nd_rusak = Item::where('kategori_id','4')->where('status_fisik','2')->get()->count();
        $nd_baik = Item::where('kategori_id','4')->where('status_fisik','1')->get()->count();

        //PERIPHERAL (Kategori = 5)
        $peripheral_total = Item::where('kategori_id','5')->get()->count();
        $peripheral_rusak = Item::where('kategori_id','5')->where('status_fisik','2')->get()->count();
        $peripheral_baik = Item::where('kategori_id','5')->where('status_fisik','1')->get()->count();

        //CONSUMABLE (Kategori = 6)
        $consumable_total = Item::where('kategori_id','6')->get()->count();

        $jumlah_item_ready = Item::where('status_item','1')->get()->count();
        $jumlah_item_na = Item::where('status_item','2')->get()->count();

        $jumlah_item_keluar = Item::where('status_item', 2)->where('kategori_id', '!=', '4' )->get()->count();
        $jumlah_item_nd_terinstall = Item::with(['network_device'])->whereHas('network_device')->get()->count();
        // dd($jumlah_item_nd_terinstall);
        $jumlah_item_masuk = ItemMasuk::all()->count();
        $jumlah_item_kerusakan = Kerusakan::all()->count();    
        $jumlah_total_aset = Item::where('kategori_id', '!=', '6')->count();
        $jumlah_total_aset_all = Item::selectRaw('sum(jumlah) as jumlah_stok_all')->get();
        $jumlah_item_ready = Item::where('kategori_id', '!=', '6')->where('status_item','1')->count();
        $jumlah_consumable = Item::selectRaw('sum(jumlah) as jumlah_stok_all')->where('kategori_id', '=', '6')->get();

        $device = [
            'Laptop'=>$laptop_total,
            'Printer'=>$printer_total,
            'PC'=>$pc_total,
            'Network Device'=>$nd_total,
            'Peripheral'=>$peripheral_total,
            'Consumable'=>$consumable_total
        ];

        return view('admin.index',compact(['jumlah_total_aset','jumlah_consumable','jumlah_total_aset_all','device','jumlah_item_keluar','jumlah_item_masuk','jumlah_item_ready','jumlah_item_nd_terinstall']));
    }

    public function qrcode($id)
    {
 
        $item = Item::where('id',$id)->first();
        if($item->kategori_id == '4'){
            $data = Item::with(['network_device','network_device.lokasi_network_device',])->where('id',$id)->first();
            $kode = "Nomor Aset : ".$data->kode_item." | Nama : ".$data->nama_item." | IP : ".$data->network_device->ip." | Lokasi : ".$data->network_device->lokasi_network_device->nama_lokasi." | Tanggal : ".TanggalIndo::tanggal_indo($data->network_device->tanggal);
        }else{
            $data = Item::with('item_keluar')->where('id',$id)->first();
            $response = Http::get('http://localhost:8282/hr-rmk2/public/api/karyawan/'.$data->item_keluar->nip);
            $datakaryawan = json_decode($response)[0];
            $kode = "Nomor Aset : ".$data->kode_item." | Spesifikasi : ".$data->deskripsi." | User : ".$datakaryawan->nama." | Jabatan : ".$datakaryawan->jabatan->jabatan." | Departemen : ".$datakaryawan->departemen->departemen." | Tanggal : ".TanggalIndo::tanggal_indo($data->item_keluar->tanggal);
        }

        $image = QrCode::format('png')
        ->merge('assets/images/LOGO-RMKE.jpg', .3, true)
        ->size(500)->errorCorrection('H')
        ->generate($kode);
        $qrcode = base64_encode($image);
        
        return view('qrCode',compact('qrcode'));
    }

    public function itemGrafik()
    {

        // item->status_fisik : 1=baik, 2=rusak
        // item->status_item : //1=ready, 2=not available, 3=request
        // Kategori = ['LAPTOP','PRINTER','PC','NETWORK DEVICE','PERIPHERALS','CONSUMABLE'];

        //LAPTOP (Kategori = 1)
        $laptop_total = Item::where('kategori_id','1')->get()->count();
        $laptop_rusak = Item::where('kategori_id','1')->where('status_fisik','2')->get()->count();
        $laptop_baik = Item::where('kategori_id','1')->where('status_fisik','1')->get()->count();

        //PRINTER (Kategori = 2)
        $printer_total = Item::where('kategori_id','2')->get()->count();
        $printer_rusak = Item::where('kategori_id','2')->where('status_fisik','2')->get()->count();
        $printer_baik = Item::where('kategori_id','2')->where('status_fisik','1')->get()->count();

        //PC (Kategori = 3)
        $pc_total = Item::where('kategori_id','3')->get()->count();
        $pc_rusak = Item::where('kategori_id','3')->where('status_fisik','2')->get()->count();
        $pc_baik = Item::where('kategori_id','3')->where('status_fisik','1')->get()->count();

        //NETWORK DEVICE (Kategori = 4)
        $nd_total = Item::where('kategori_id','4')->get()->count();
        $nd_rusak = Item::where('kategori_id','4')->where('status_fisik','2')->get()->count();
        $nd_baik = Item::where('kategori_id','4')->where('status_fisik','1')->get()->count();

        //PERIPHERAL (Kategori = 5)
        $peripheral_total = Item::where('kategori_id','5')->get()->count();
        $peripheral_rusak = Item::where('kategori_id','5')->where('status_fisik','2')->get()->count();
        $peripheral_baik = Item::where('kategori_id','5')->where('status_fisik','1')->get()->count();

        //CONSUMABLE (Kategori = 6)
        $consumable_total = Item::where('kategori_id','6')->get()->count();

        $jumlah_item_ready = Item::where('status_item','1')->get()->count();
        $jumlah_item_na = Item::where('status_item','2')->get()->count();

        $jumlah_item_keluar = ItemKeluar::all()->count();
        $jumlah_item_masuk = ItemMasuk::all()->count();
        $jumlah_item_kerusakan = Kerusakan::all()->count();  
        
        $total = [$laptop_total, $printer_total, $pc_total, $nd_total, $peripheral_total, $consumable_total];
        $baik = [$laptop_baik, $printer_baik, $pc_baik, $nd_baik, $peripheral_baik, 0];
        $rusak = [$laptop_rusak, $printer_rusak, $pc_rusak, $nd_rusak, $peripheral_rusak, 0];

        return response()->json(['total'=>$total, 'baik'=>$baik, 'rusak'=>$rusak]);
    }

    public function permintaanGrafik()
    {
        $totalPermintaanperbln = Permintaan::whereYear('tanggal', date('Y'))->count();
        $permintaanpendingperbln = Permintaan::whereYear('tanggal', date('Y'))->where('status_permintaan','!=','3')->count();
        $permintaancompleteperbln = Permintaan::whereYear('tanggal', date('Y'))->where('status_permintaan','3')->count();

        $bln = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        return response()->json(['total'=>$totalPermintaanperbln, 'pending'=>$permintaanpendingperbln, 'complete'=>$permintaancompleteperbln, 'tahun'=>date('Y')]);

    }
}
