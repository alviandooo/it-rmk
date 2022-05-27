<?php

namespace App\Http\Controllers;

use App\Exports\TransaksiExport;
use App\Models\ItemKeluar;
use App\Models\ItemMasuk;
use App\Models\ItemPerbaikan;
use App\Models\Kategori;
use App\Models\Kerusakan;
use App\Models\NetworkDevice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;
use PDF;


class LaporanController extends Controller
{
    public function laporantransaksi()
    {
        return view('admin.laporan.transaksi.transaksi');
    }

    public function checklaporantransaksi(Request $request)
    {
        // jenis laporan = 0-pengembalian, 1-penyerahan, 2-kerusakan/perbaikan, 3-upgrade, 4-semua
        $tglawal = date("Y-m-d", strtotime($request->tanggal_awal));
        $tglakhir = date("Y-m-d", strtotime($request->tanggal_akhir));

        $dataf = array();
        //item masuk
        if($request->jenis_laporan == '0'){
            $data =  ItemMasuk::with(['item', 'item.kategori'])->whereBetween('tanggal', [$tglawal, $tglakhir])->get();
        }else if($request->jenis_laporan == '1'){
            $data = ItemKeluar::with(['item', 'item.kategori'])->whereBetween('tanggal', [$tglawal, $tglakhir])->get();
        }else if($request->jenis_laporan == '2'){
            $data = Kerusakan::with(['item', 'item.kategori'])->whereBetween('tanggal', [$tglawal, $tglakhir])->get();
        }else if($request->jenis_laporan == '3'){
            $data = ItemPerbaikan::with(['item', 'item.kategori'])->whereBetween('tanggal_perbaikan', [$tglawal, $tglakhir])->get();
        }else if($request->jenis_laporan == '5') {
            $data = NetworkDevice::with(['item','lokasi_network_device','lokasi_network_device.area_lokasi_network_device'])->whereBetween('tanggal', [$tglawal, $tglakhir])->get();
        }else if($request->jenis_laporan == '4'){
            $im =  ItemMasuk::with(['item', 'item.kategori'])->whereBetween('tanggal', [$tglawal, $tglakhir])->get();
            // $ik =  ItemKeluar::with(['item', 'item.kategori'])->whereBetween('tanggal', [$tglawal, $tglakhir])->get();
            // $k = Kerusakan::with(['item', 'item.kategori'])->whereBetween('tanggal', [$tglawal, $tglakhir])->get();
            // $ip =  ItemPerbaikan::with(['item', 'item.kategori'])->whereBetween('tanggal_perbaikan', [$tglawal, $tglakhir])->get();
            // foreach ($im as $key => $m) {
            //     if($m->nip != null){
            //         $jenis = "DIKEMBALIKAN";
            //     }else{
            //         $jenis = "DITERIMA";
            //     }
            //     array_push($dataf, ['kode_item'=>$m->kode_item, 'kategori'=> $m->item->kategori->kategori, 'serie'=> $m->item->serie_item, 'tanggal'=>$m->tanggal, 'jenis'=>$jenis, 'nip'=>$m->nip, 'deskripsi'=>$m->deskripsi, 'created_at'=>$m->created_at]);
            // }
            // foreach ($ik as $key => $itk) {
            //     array_push($dataf, ['kode_item'=>$itk->kode_item, 'kategori'=> $itk->item->kategori->kategori, 'serie'=> $itk->item->serie_item, 'tanggal'=>$itk->tanggal, 'jenis'=>'DISERAHKAN', 'nip'=>$itk->nip, 'deskripsi'=>$itk->deskripsi, 'created_at'=>$itk->created_at]);
            // }
            // foreach ($k as $key => $k) {
            //     array_push($dataf, ['kode_item'=>$k->kode_item, 'kategori'=> $k->item->kategori->kategori, 'serie'=> $k->item->serie_item, 'tanggal'=>$k->tanggal, 'jenis'=>'KERUSAKAN', 'nip'=>$k->nip, 'deskripsi'=>$k->deskripsi, 'created_at'=>$k->created_at]);
            // }
            // foreach ($ip as $key => $p) {
            //     array_push($dataf, ['kode_item'=>$p->kode_item, 'kategori'=> $p->item->kategori->kategori, 'serie'=> $p->item->serie_item, 'tanggal'=>$p->tanggal_perbaikan, 'jenis'=>'PERBAIKAN', 'nip'=>$p->nip, 'deskripsi'=>$p->deskripsi, 'created_at'=>$p->created_at]);
            // }

            // $data = $dataf;
                $data = $im;
        }

        if (($data->count() != '0') or ($request->jenis_laporan == '4' && count($data) != '0')) {
            return response()->json(['status'=>200]);
        }else if($data){
            return response()->json(['text'=>'Silahkan pilih tanggal yang sesuai!','status'=>422]);
        }else{
            return response()->json(['text'=>'Silahkan pilih tanggal yang sesuai!','status'=>412]);
        }
    }

    public function datalaporantransaksi($jenis_transaksi, $tgl_awal, $tgl_akhir)
    {
        // jenis laporan = 0-pengembalian, 1-penyerahan, 2-kerusakan/perbaikan, 3-upgrade, 4-semua, 5-pemasangan network device
        $tglawal = date("Y-m-d", strtotime($tgl_awal));
        $tglakhir = date("Y-m-d", strtotime($tgl_akhir));
        $dataf = array();
        //item masuk
        if($jenis_transaksi == '0'){
            $data =  ItemMasuk::with(['item','item.kategori'=>function ($query)
            {
                $query->selectRaw('*')->where('id','!=','4')->get();
            }])->where('nip', '!=', null)->whereBetween('tanggal', [$tglawal, $tglakhir])->get();
        }else if($jenis_transaksi == '1'){
            $data = ItemKeluar::with(['item','item.kategori'=>function ($query)
            {
                $query->selectRaw('*')->where('id','!=','4')->get();
            }])->whereBetween('tanggal', [$tglawal, $tglakhir])->get();
        }else if($jenis_transaksi == '2'){
            $data = Kerusakan::with(['item','item.kategori'=>function ($query)
            {
                $query->selectRaw('*')->where('id','!=','4')->get();
            }])->whereBetween('tanggal', [$tglawal, $tglakhir])->get();
        }else if($jenis_transaksi == '3'){
            $data = ItemPerbaikan::with(['item','item.kategori'=>function ($query)
            {
                $query->selectRaw('*')->where('id','!=','4')->get();
            }])->whereBetween('tanggal_perbaikan', [$tglawal, $tglakhir])->get();
        }else if($jenis_transaksi == '5'){
            $data = NetworkDevice::with(['item','lokasi_network_device','lokasi_network_device.area_lokasi_network_device'])->whereBetween('tanggal', [$tglawal, $tglakhir])->get();
        }else if($jenis_transaksi == '4'){
            $im =  ItemMasuk::with(['item','item.kategori'=>function ($query)
            {
                $query->selectRaw('*')->where('id','!=','4')->get();
            }])->whereBetween('tanggal', [$tglawal, $tglakhir])->get();
            // $ik =  ItemKeluar::with(['item','item.kategori'=>function ($query)
            // {
            //     $query->selectRaw('*')->where('id','!=','4')->get();
            // }])->whereBetween('tanggal', [$tglawal, $tglakhir])->get();
            // $k = Kerusakan::with(['item','item.kategori'=>function ($query)
            // {
            //     $query->selectRaw('*')->where('id','!=','4')->get();
            // }])->whereBetween('tanggal', [$tglawal, $tglakhir])->get();
            // $ip =  ItemPerbaikan::with(['item','item.kategori'=>function ($query)
            // {
            //     $query->selectRaw('*')->where('id','!=','4')->get();
            // }])->whereBetween('tanggal_perbaikan', [$tglawal, $tglakhir])->get();
            
            // foreach ($im as $key => $m) {
            //     array_push($dataf, ['kode_item'=>$m->kode_item, 'nama_item'=>$m->item->nama_item,  'tanggal'=>$m->tanggal, 'kategori'=> $m->item->kategori->kategori, 'serie'=> $m->item->serie_item, 'jenis'=>'DIKEMBALIKAN', 'nip'=>$m->nip, 'deskripsi'=>$m->deskripsi, 'created_at'=>$m->created_at]);
            // }
            // foreach ($ik as $key => $itk) {
            //     array_push($dataf, ['kode_item'=>$itk->kode_item, 'nama_item'=>$itk->item->nama_item, 'tanggal'=>$itk->tanggal, 'kategori'=> $itk->item->kategori->kategori, 'serie'=> $itk->item->serie_item, 'jenis'=>'DISERAHKAN', 'nip'=>$itk->nip, 'deskripsi'=>$itk->deskripsi, 'created_at'=>$itk->created_at]);
            // }
            // foreach ($k as $key => $k) {
            //     array_push($dataf, ['kode_item'=>$k->kode_item, 'nama_item'=>$k->item->nama_item, 'tanggal'=>$k->tanggal, 'kategori'=> $k->item->kategori->kategori, 'serie'=> $k->item->serie_item, 'jenis'=>'KERUSAKAN', 'nip'=>$k->nip, 'deskripsi'=>$k->deskripsi, 'created_at'=>$k->created_at]);
            // }
            // foreach ($ip as $key => $p) {
            //     array_push($dataf, ['kode_item'=>$p->kode_item, 'nama_item'=>$p->item->nama_item, 'tanggal'=>$p->tanggal_perbaikan, 'kategori'=> $p->item->kategori->kategori, 'serie'=> $p->item->serie_item, 'jenis'=>'PERBAIKAN', 'nip'=>$p->nip, 'deskripsi'=>$p->deskripsi, 'created_at'=>$p->created_at]);
            // }

            $data = $dataf;
        }
        if($jenis_transaksi != '5'){
            $response = Http::get('http://localhost:8282/hr-rmk2/public/api/karyawan/all/data');
            $datakaryawan = json_decode($response);
            $result=[];
            $final = array();
            $niptemp="";
    
            foreach ($data as $key => $d) {
                $niptemp = $d->nip;
                foreach ($datakaryawan as $key => $dk) {
                    if($dk->nip == $niptemp){
                        $result['nama'] = $dk->nama;
                        $result['jabatan'] = $dk->jabatan->jabatan;
                        $result['departemen'] = $dk->departemen->departemen;
                        $result['nip'] = $dk->nip;
    
                        break;
                    }
                }
                if($d->tanggal){
                    $tanggal = $d->tanggal;
                }else{
                    $tanggal = $d->tanggal_perbaikan;
                }
                $result['id']=$d->id;
                $result['tanggal']=$tanggal;
                $result['kode_item']=$d->kode_item;
                $result['kategori']=$d->item->kategori->kategori;
                $result['nama_item']=$d->item->nama_item;
                $result['serie_item']=$d->item->serie_item;
                $result['kategori']=$d->item->kategori->kategori;
                $result['created_at']=$d->item->created_at;
    
                array_push($final,  $result);
            }
    
            return datatables()->of($final)->make(true);
        }else if($jenis_transaksi == '5'){
            return datatables()->of($data)->make(true);
        }

    }

    public function exportlaporantransaksi($jenis_export, $jenis_transaksi, $tgl_awal, $tgl_akhir)
    {
        // jenis laporan = 0-pengembalian, 1-penyerahan, 2-kerusakan/perbaikan, 3-upgrade, 4-semua
        $tglawal = date("Y-m-d", strtotime($tgl_awal));
        $tglakhir = date("Y-m-d", strtotime($tgl_akhir));

        $dataf = array();
        //item masuk
        if($jenis_transaksi == '0'){
            $data =  ItemMasuk::with(['item','item.kategori'=>function ($query)
            {
                $query->selectRaw('*')->where('id','!=','4')->get();
            }])->where('nip', '!=', null)->whereBetween('tanggal', [$tglawal, $tglakhir])->get();
        }else if($jenis_transaksi == '1'){ 
            $data = ItemKeluar::with(['item','item.kategori'=>function ($query)
            {
                $query->selectRaw('*')->where('id','!=','4')->get();
            }])->whereBetween('tanggal', [$tglawal, $tglakhir])->get();
        }else if($jenis_transaksi == '2'){
            $data = Kerusakan::with(['item','item.kategori'=>function ($query)
            {
                $query->selectRaw('*')->where('id','!=','4')->get();
            }])->whereBetween('tanggal', [$tglawal, $tglakhir])->get();
        }else if($jenis_transaksi == '3'){
            
            $data = ItemPerbaikan::with(['item','item.kategori'=>function ($query)
            {
                $query->selectRaw('*')->where('id','!=','4')->get();
            }])->whereBetween('tanggal_perbaikan', [$tglawal, $tglakhir])->get();

        }else if($jenis_transaksi == '4'){
            $im =  ItemMasuk::with(['item','item.kategori'=>function ($query)
            {
                $query->selectRaw('*')->where('id','!=','4')->get();
            }])->whereBetween('tanggal', [$tglawal, $tglakhir])->get();
            // $ik =  ItemKeluar::with(['item','item.kategori'=>function ($query)
            // {
            //     $query->selectRaw('*')->where('id','!=','4')->get();
            // }])->whereBetween('tanggal', [$tglawal, $tglakhir])->get();
            // $k = Kerusakan::with(['item','item.kategori'=>function ($query)
            // {
            //     $query->selectRaw('*')->where('id','!=','4')->get();
            // }])->whereBetween('tanggal', [$tglawal, $tglakhir])->get();
            // $ip =  ItemPerbaikan::with(['item','item.kategori'=>function ($query)
            // {
            //     $query->selectRaw('*')->where('id','!=','4')->get();
            // }])->whereBetween('tanggal_perbaikan', [$tglawal, $tglakhir])->get();
            
            // foreach ($im as $key => $m) {
            //     array_push($dataf, ['kode_item'=>$m->kode_item, 'nama_item'=>$m->item->nama_item,  'tanggal'=>$m->tanggal, 'kategori'=> $m->item->kategori->kategori, 'serie'=> $m->item->serie_item, 'jenis'=>'DIKEMBALIKAN', 'nip'=>$m->nip, 'deskripsi'=>$m->deskripsi, 'created_at'=>$m->created_at]);
            // }
            // foreach ($ik as $key => $itk) {
            //     array_push($dataf, ['kode_item'=>$itk->kode_item, 'nama_item'=>$itk->item->nama_item, 'tanggal'=>$itk->tanggal, 'kategori'=> $itk->item->kategori->kategori, 'serie'=> $itk->item->serie_item, 'jenis'=>'DISERAHKAN', 'nip'=>$itk->nip, 'deskripsi'=>$itk->deskripsi, 'created_at'=>$itk->created_at]);
            // }
            // foreach ($k as $key => $k) {
            //     array_push($dataf, ['kode_item'=>$k->kode_item, 'nama_item'=>$k->item->nama_item, 'tanggal'=>$k->tanggal, 'kategori'=> $k->item->kategori->kategori, 'serie'=> $k->item->serie_item, 'jenis'=>'KERUSAKAN', 'nip'=>$k->nip, 'deskripsi'=>$k->deskripsi, 'created_at'=>$k->created_at]);
            // }
            // foreach ($ip as $key => $p) {
            //     array_push($dataf, ['kode_item'=>$p->kode_item, 'nama_item'=>$p->item->nama_item, 'tanggal'=>$p->tanggal_perbaikan, 'kategori'=> $p->item->kategori->kategori, 'serie'=> $p->item->serie_item, 'jenis'=>'PERBAIKAN', 'nip'=>$p->nip, 'deskripsi'=>$p->deskripsi, 'created_at'=>$p->created_at]);
            // }

            $data = $dataf;
        }else if($jenis_transaksi == '5'){
            $data = NetworkDevice::with(['item','lokasi_network_device','lokasi_network_device.area_lokasi_network_device'])->whereBetween('tanggal', [$tglawal, $tglakhir])->get();
            $data = $data->groupBy('lokasi_network_device.area_lokasi_network_device.nama_area_lokasi');
        }

        if($jenis_transaksi != '5'){
            $response = Http::get('http://localhost:8282/hr-rmk2/public/api/karyawan/all/data');
            $datakaryawan = json_decode($response);
            $result=[];
            $final = array();
            $niptemp="";

            foreach ($data as $key => $d) {
                $niptemp = $d->nip;
                foreach ($datakaryawan as $key => $dk) {
                    if($dk->nip == $niptemp){
                        $result['nama'] = $dk->nama;
                        $result['jabatan'] = $dk->jabatan->jabatan;
                        $result['departemen'] = $dk->departemen->departemen;
                        $result['nip'] = $dk->nip;

                        break;
                    }
                }
                $result['id']=$d->id;
                $result['tanggal']=$d->tanggal;
                $result['kode_item']=$d->kode_item;
                $result['kategori']=$d->item->kategori->kategori;
                $result['nama_item']=$d->item->nama_item;
                $result['serie_item']=$d->item->serie_item;
                $result['kategori']=$d->item->kategori->kategori;
                $result['created_at']=$d->item->created_at;

                array_push($final,  $result);
            }

            if($jenis_export == '1'){
                // excel
                return Excel::download(new TransaksiExport($final, $jenis_transaksi), 'Transaksi.xlsx');
            }else if($jenis_export == '2'){
                $pdf = PDF::loadView('admin.laporan.transaksi.export.pdf', compact(['final','tglawal','tglakhir']))->setPaper('a4', 'potrait')->setWarnings(false);
                return $pdf->stream();
            }
        }else if($jenis_transaksi == '5'){
            if($jenis_export == '1'){
                // excel
                return Excel::download(new TransaksiExport($data, $jenis_transaksi), 'Transaksi.xlsx');
            }else if($jenis_export == '2'){
                $pdf = PDF::loadView('admin.laporan.transaksi.export.network-device-pdf', compact(['data','tglawal','tglakhir']))->setPaper('a4', 'potrait')->setWarnings(false);
                return $pdf->stream();
            }
        }
        

    }
    
}
