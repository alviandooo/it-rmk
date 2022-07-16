<?php

namespace App\Http\Controllers;

use App\Exports\StokExport;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Kategori;
use App\Models\ItemMasuk;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class StokController extends Controller
{
    public function index()
    {
        return view('admin.inventaris.stok.index');
    }

    public function indexConsumable()
    {
        return view('admin.inventaris.stok.consumable.index');
    }

    public function all()
    {
        $data = Item::with(['kategori','satuan'])->selectRaw('*, count(*) as jumlah_item')->where('kategori_id','!=','6')->where('status_item',1)->groupBy('kategori_id')->get();
        return datatables()->of($data)->make(true);
    }

    public function allconsumable()
    {
        $data = Item::with(['kategori','satuan'])->selectRaw('*, count(*) as jumlah_item, sum(jumlah) as stok')->where('kategori_id','6')->where('status_item',1)->groupBy('kategori_id')->get();
        return datatables()->of($data)->make(true);
    }

    public function detail()
    {
        $kategori = Kategori::find(request()->segment(4))->kategori;
        return view('admin.inventaris.stok.detail', compact(['kategori']));
    }

    public function detailbytanggal($tgl_awal, $tgl_akhir, $jenis_data)
    {
        $tglawal = date("Y-m-d", strtotime($tgl_awal));
        $tglakhir = date("Y-m-d", strtotime($tgl_akhir));

        if($jenis_data == '1'){
            //aset masuk
            $datatemp = ItemMasuk::with(['item', 'item.kategori'])->where('nip', null)->whereBetween('tanggal', [$tglawal, $tglakhir])->get();
        }else if($jenis_data == '2'){
            //aset ready
            $datatemp = collect(ItemMasuk::with(['item', 'item.kategori'])->get())->where('item.status_item','1');

            // $datatemp = ItemMasuk::with(['item'=>function ($query)
            // {
            //     $query->selectRaw('*')->where('status_item','1');
            // },'item.kategori'])->get();
        }else{
            $datatemp = ItemMasuk::with(['item', 'item.kategori'])->where('nip', null)->whereBetween('tanggal', [$tglawal, $tglakhir])->get();
        }

        // $datatemp = ItemMasuk::with(['item', 'item.kategori'])->selectRaw('*, count(*) as jumlah')->whereBetween('tanggal', [$tglawal, $tglakhir])->groupBy('kode_item')->get();
        // $data = $datatemp->where('item.status_item',1);
        return datatables()->of($datatemp)->make(true);

    }

    public function detailbykategori($kategori_id)
    {
        $data = Item::with(['kategori','satuan'])->where('kategori_id',$kategori_id)->where('status_item',1)->get();
        return datatables()->of($data)->make(true);
    }

    public function laporan()
    {
        return view('admin.laporan.stok.stok');
    }

    public function datalaporan(Request $request)
    {

        $d = [];
        $tglawal = date("Y-m-d", strtotime($request->tanggal_awal));
        $tglakhir = date("Y-m-d", strtotime($request->tanggal_akhir));
        $jenis = $request->jenis_laporan;
        $jenis_data = $request->jenis_data;

        if($jenis_data == '1'){
            //aset masuk
            $datatemp = ItemMasuk::with(['item', 'item.kategori'])->where('nip', null)->whereBetween('tanggal', [$tglawal, $tglakhir])->get();
        }else{
            //aset ready
            // $datatemp = ItemMasuk::with(['item', 'item.kategori'])->get();
            $datatemp = collect(ItemMasuk::with(['item', 'item.kategori'])->get())->where('item.status_item','1');

        }
        
        // $datatemp = ItemMasuk::with(['item', 'item.kategori'])->selectRaw('*, count(*) as jumlah')->whereBetween('tanggal', [$tglawal, $tglakhir])->groupBy('kode_item')->get();
        // $data = $datatemp->where('item.status_item',1);
        $data = $datatemp;        

        $total = $data->count();
        $totalperkategori = $data->groupBy('item.kategori.kategori')->map(function ($row) {
            return $row->count();
        });
        
        $laptop = isset($totalperkategori['LAPTOP']) ? $totalperkategori['LAPTOP'] : 0 ;
        $printer = isset($totalperkategori['PRITNER']) ? $totalperkategori['PRITNER'] : 0;
        $pc = isset($totalperkategori['PC']) ? $totalperkategori['PC'] : 0;
        $nd = isset($totalperkategori['NETWORK DEVICE']) ? $totalperkategori['NETWORK DEVICE'] : 0;
        $peripheral = isset($totalperkategori['PERIPHERAL']) ? $totalperkategori['PERIPHERAL'] : 0;
        $consumable = isset($totalperkategori['CONSUMABLE']) ? $totalperkategori['CONSUMABLE'] : 0;

        $totalkategori = (['LAPTOP'=>$laptop, 'PRINTER'=>$printer, 'PC'=>$pc, 'NETWORK_DEVICE'=>$nd, 'PERIPHERAL'=>$peripheral, 'CONSUMABLE'=>$consumable]);

        $dataperkategori = $data->groupBy('item.kategori.kategori');
        $d['jenis_data'] = $jenis_data;
        $d['data'] = $data;
        $d['total'] = $total;
        $d['totalperkategori'] = $totalkategori;
        $d['dataperkategori'] = $dataperkategori;
        $d['totalkategori'] = $totalperkategori;
        if ($jenis == null) {
            if ($total != '0') {
                return response()->json(['data'=>$d, 'status'=>200]);
            }else{
                return response()->json(['text'=>'Silahkan pilih tanggal yang sesuai!', 'status'=>422]);
            }
        }else if($jenis == '1'){
            //excel
            if($jenis_data == '1'){
                return Excel::download(new StokExport($d), 'Stok-masuk.xlsx');
            }else{
                return Excel::download(new StokExport($d), 'Stok-ready.xlsx');
            }

        }else if($jenis == '2'){
            //pdf
            $pdf = PDF::loadView('admin.laporan.stok.export.stok-pdf', compact(['d','tglawal','tglakhir']))->setPaper('a4', 'potrait')->setWarnings(false);
            return $pdf->stream();
        }else{
            return 'Silahkan pilih format laporan!';
        }

    }

}
