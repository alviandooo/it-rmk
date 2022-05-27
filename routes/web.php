<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AreaLokasiController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ItemMasukController;
use App\Http\Controllers\ItemKeluarController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermintaanController;
use App\Http\Controllers\ItemPerbaikanController;
use App\Http\Controllers\ItemPermintaanController;
use App\Http\Controllers\KerusakanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\NetworkDeviceController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ItemUpgradeController;
use App\Http\Controllers\SAPItemController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/pdf', function () {
//     $pdf = PDF::loadView('admin.permintaan.export.pdf')->setPaper('a4', 'potrait')->setWarnings(false);
//     return $pdf->stream();
//     // return view('admin.inventaris.keluar.export.pdf');
// });

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/ims-test', function ()
{
   return view('index-ims'); 
});
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/qr-check/{dataqr}', [LoginController::class, 'qrlogin'])->name('login.qrlogin');

Route::middleware(['auth'])->group(function (){
    // dashboard
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/dashboard/grafik', [AdminController::class, 'itemGrafik'])->name('admin.grafik');
    Route::get('/admin/dashboard/grafik/order', [AdminController::class, 'permintaanGrafik'])->name('admin.permintaangrafik');

    //route kategori
    Route::get('/admin/kategori', [KategoriController::class, 'index'])->name('kategori.index');
    Route::get('/admin/kategori/edit/{id}', [KategoriController::class, 'edit'])->name('kategori.edit');
    Route::get('/admin/kategori/all', [KategoriController::class, 'getAll'])->name('kategori.getAll');
    Route::post('/admin/kategori/store', [KategoriController::class, 'store'])->name('kategori.store');
    Route::post('/admin/kategori/update', [KategoriController::class, 'update'])->name('kategori.update');
    Route::post('/admin/kategori/delete', [KategoriController::class, 'destroy'])->name('kategori.delete');
    
    // route satuan
    Route::get('/admin/satuan', [SatuanController::class, 'index'])->name('satuan.index');
    Route::get('/admin/satuan/edit/{id}', [SatuanController::class, 'edit'])->name('satuan.edit');
    Route::get('/admin/satuan/all', [SatuanController::class, 'getAll'])->name('satuan.getAll');
    Route::post('/admin/satuan/store', [SatuanController::class, 'store'])->name('satuan.store');
    Route::post('/admin/satuan/update', [SatuanController::class, 'update'])->name('satuan.update');
    Route::post('/admin/satuan/delete', [SatuanController::class, 'destroy'])->name('satuan.delete');

    // route sap item
    Route::get('/admin/item/sap', [SAPItemController::class, 'index'])->name('sap.index');
    Route::get('/admin/item/sap/{id}', [SAPItemController::class, 'edit'])->name('sap.edit');
    Route::post('/admin/item/sap/store', [SAPItemController::class, 'store'])->name('sap.store');
    
    //  route item
    Route::get('/admin/item', [ItemController::class, 'index'])->name('item.index');
    Route::get('/admin/item/laptop', [ItemController::class, 'laptop'])->name('item.laptop');
    Route::get('/admin/item/laptop/data', [ItemController::class, 'datalaptop'])->name('item.datalaptop');
    Route::get('/admin/item/printer', [ItemController::class, 'printer'])->name('item.printer');
    Route::get('/admin/item/printer/data', [ItemController::class, 'dataprinter'])->name('item.dataprinter');
    Route::get('/admin/item/pc', [ItemController::class, 'pc'])->name('item.pc');
    Route::get('/admin/item/pc/data', [ItemController::class, 'datapc'])->name('item.datapc');
    Route::get('/admin/item/peripheral', [ItemController::class, 'peripheral'])->name('item.peripheral');
    Route::get('/admin/item/peripheral/data', [ItemController::class, 'dataperipheral'])->name('item.dataperipheral');
    Route::get('/admin/item/network-device', [ItemController::class, 'networkDevice'])->name('item.nd');
    Route::get('/admin/item/network-device/data', [ItemController::class, 'datanetworkDevice'])->name('item.datand');
    Route::get('/admin/item/consumable', [ItemController::class, 'consumable'])->name('item.consumable');
    Route::get('/admin/item/consumable/data', [ItemController::class, 'dataconsumable'])->name('item.dataconsumable');
    
    Route::get('/admin/item/all', [ItemController::class, 'getAll'])->name('item.getAll');
    Route::get('/admin/item/{kode_item}', [ItemController::class, 'itembykode'])->name('item.itembykode');
    Route::get('/admin/item/{id}/data', [ItemController::class, 'itembyid'])->name('item.itembyid');
    Route::get('/admin/item/edit/{id}', [ItemController::class, 'edit'])->name('item.edit');
    Route::get('/admin/item/riwayat-aset/{id}', [ItemController::class, 'riwayatkode'])->name('item.riwayatkode');
    Route::get('/admin/item/riwayat-aset/{id}/service', [ItemController::class, 'getRiwayatService'])->name('item.getRiwayatService');
    Route::get('/admin/item/riwayat-aset/{id}/item-service', [ItemController::class, 'getRiwayatItemService'])->name('item.getRiwayatItemService');
    Route::get('/admin/item/riwayat-nip/{nip}', [ItemController::class, 'riwayatnip'])->name('item.riwayatnip');
    Route::post('/admin/item/store', [ItemController::class, 'store'])->name('item.store');
    Route::post('/admin/item/update', [ItemController::class, 'update'])->name('item.update');
    Route::post('/admin/item/destroy', [ItemController::class, 'destroy'])->name('item.destroy');

        //export item
    Route::get('/admin/item/kategori/{kategori_id}/{jenis_export}/excel', [ItemController::class, 'exportitembykategori'])->name('item.exportitembykategori');
    Route::get('/admin/item/nd/export/{jenis_export}', [ItemController::class, 'exportnd'])->name('item.exportnd');
    
    
    //route inventaris Upgrade
    Route::get('/admin/inventaris/upgrade/all', [ItemUpgradeController::class, 'getAll'])->name('itemupgrade.getAll');
    Route::get('/admin/inventaris/upgrade/data/{id}', [ItemUpgradeController::class, 'getByKodeItem'])->name('itemupgrade.getByKodeItem');

    Route::post('/admin/inventaris/upgrade/store', [ItemUpgradeController::class, 'store'])->name('itemupgrade.store');
    Route::post('/admin/inventaris/upgrade/delete', [ItemUpgradeController::class, 'destroy'])->name('itemupgrade.delete');


    // route inventaris masuk
    Route::get('/admin/inventaris/masuk', [ItemMasukController::class, 'index'])->name('itemmasuk.index');
    Route::get('/admin/inventaris/masuk/all', [ItemMasukController::class, 'all'])->name('itemmasuk.all');
    Route::get('/admin/inventaris/masuk/edit/{id}', [ItemMasukController::class, 'edit'])->name('itemmasuk.edit');
    Route::post('/admin/inventaris/masuk/store', [ItemMasukController::class, 'store'])->name('itemmasuk.store');
    Route::post('/admin/inventaris/masuk/update', [ItemMasukController::class, 'update'])->name('itemmasuk.update');
    Route::post('/admin/inventaris/masuk/data-item-keluar', [ItemMasukController::class, 'getItemKeluar'])->name('itemmasuk.getitemkeluar');
    Route::post('/admin/inventaris/masuk/pdf', [ItemMasukController::class, 'pdf'])->name('itemmasuk.pdf');
    Route::post('/admin/inventaris/masuk/store/gambar', [ItemMasukController::class, 'uploadgambar'])->name('itemmasuk.uploadgambar');
    
    // route inventaris keluar
    Route::get('/admin/inventaris/keluar', [ItemKeluarController::class, 'index'])->name('itemkeluar.index');
    Route::get('/admin/inventaris/keluar/all', [ItemKeluarController::class, 'all'])->name('itemkeluar.all');
    Route::get('/admin/inventaris/keluar/edit/{id}', [ItemKeluarController::class, 'edit'])->name('itemkeluar.edit');
    Route::post('/admin/inventaris/keluar/update', [ItemKeluarController::class, 'update'])->name('itemkeluar.update');
    Route::post('/admin/inventaris/keluar/pdf', [ItemKeluarController::class, 'pdf'])->name('itemkeluar.pdf');
    Route::post('/admin/inventaris/keluar/store', [ItemKeluarController::class, 'store'])->name('itemkeluar.store');
    Route::post('/admin/inventaris/keluar/store/gambar', [ItemKeluarController::class, 'uploadgambar'])->name('itemkeluar.uploadgambar');
    Route::post('/admin/inventaris/keluar/delete/gambar', [ItemKeluarController::class, 'deletegambar'])->name('itemkeluar.deletegambar');
    
    
    // route inventaris perbaikan
    Route::get('/admin/inventaris/perbaikan', [ItemPerbaikanController::class, 'index'])->name('itemperbaikan.index');
    Route::get('/admin/inventaris/edit/{id}', [ItemPerbaikanController::class, 'edit'])->name('itemperbaikan.edit');
    Route::get('/admin/inventaris/perbaikan/all', [ItemPerbaikanController::class, 'getAll'])->name('itemperbaikan.getAll');
    Route::post('/admin/inventaris/perbaikan/store', [ItemPerbaikanController::class, 'store'])->name('itemperbaikan.store');
    Route::post('/admin/inventaris/perbaikan/selesai', [ItemPerbaikanController::class, 'selesaiperbaikan'])->name('itemperbaikan.selesaiperbaikan');
    Route::post('/admin/inventaris/perbaikan/update', [ItemPerbaikanController::class, 'update'])->name('itemperbaikan.update');
    Route::post('/admin/inventaris/perbaikan/delete', [ItemPerbaikanController::class, 'destroy'])->name('itemperbaikan.delete');

    // route pengguna
    Route::get('/admin/pengguna/', [PenggunaController::class, 'index'])->name('pengguna.index');
    Route::get('/admin/pengguna/all', [PenggunaController::class, 'all'])->name('pengguna.all');
    Route::get('/admin/pengguna/all1', [PenggunaController::class, 'all1'])->name('pengguna.all1');
    Route::get('/admin/pengguna/{nip}/detail', [PenggunaController::class, 'detail'])->name('pengguna.detail');
    Route::get('/admin/pengguna/{nip}/detail/riwayat-pengguna', [PenggunaController::class, 'riwayatPengguna'])->name('pengguna.riwayat');
    Route::get('/admin/pengguna/{nip}/detail/riwayat-pengguna-service', [PenggunaController::class, 'getRiwayatPenggunaService'])->name('pengguna.getRiwayatPenggunaService');
    Route::get('/admin/pengguna/{nip}/detail/riwayat-pengguna-item-service', [PenggunaController::class, 'getRiwayatPenggunaItemService'])->name('pengguna.getRiwayatPenggunaItemService');
    
    //route users
    Route::get('/admin/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/admin/user/all', [UserController::class, 'all'])->name('user.all');
    Route::get('/admin/user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::post('/admin/user/store', [UserController::class, 'store'])->name('user.store');
    Route::post('/admin/user/update', [UserController::class, 'update'])->name('user.update');
    Route::post('/admin/user/delete', [UserController::class, 'destroy'])->name('user.delete');

    // route permintaan
        //data
        Route::get('/admin/permintaan', [PermintaanController::class, 'index'])->name('permintaan.index');
        Route::get('/admin/permintaan/all', [PermintaanController::class, 'getAll'])->name('permintaan.getAll');
        Route::get('/admin/permintaan/jumlah-belum-approve', [PermintaanController::class, 'getJumlahBelumApprove'])->name('permintaan.getJumlahBelumApprove');
        Route::get('/admin/permintaan/tambah', [PermintaanController::class, 'create'])->name('permintaan.tambah');
        Route::get('/admin/permintaan/edit/{id}', [PermintaanController::class, 'edit'])->name('permintaan.edit');
        Route::get('/admin/permintaan/update/{ro}/{status}', [PermintaanController::class, 'updatestatuspermintaan'])->name('permintaan.updatestatuspermintaan');
        Route::get('/admin/permintaan/pdf/{id}', [PermintaanController::class, 'pdf'])->name('permintaan.pdf');
        Route::post('/admin/permintaan/update/status-approve', [PermintaanController::class, 'updatestatusapprove'])->name('permintaan.updatestatusapprove');
        Route::post('/admin/permintaan/update', [PermintaanController::class, 'update'])->name('permintaan.update');
        Route::post('/admin/permintaan/store', [PermintaanController::class, 'store'])->name('permintaan.store');
        Route::delete('/admin/permintaan/{id}', [PermintaanController::class, 'destroy'])->name('permintaan.destroy');

        //aprovement
        Route::get('/admin/permintaan/approval', [PermintaanController::class, 'indexApprove'])->name('permintaan.indexapprove');
        Route::get('/admin/permintaan/allapprove', [PermintaanController::class, 'getAllApprove'])->name('permintaan.getAllApprove');


    // route item permintaan
    Route::get('/admin/item-permintaan/edit/{id}', [ItemPermintaanController::class, 'edit'])->name('itempermintaan.edit');
    Route::get('/admin/item-permintaan/update/{id}/{status}', [ItemPermintaanController::class, 'updatestatusitem'])->name('itempermintaan.updatestatusitem');
    Route::post('/admin/item-permintaan/delete', [ItemPermintaanController::class, 'destroy'])->name('itempermintaan.delete');
    Route::post('/admin/item-permintaan/update', [ItemPermintaanController::class, 'update'])->name('itempermintaan.update');

    // route kerusakan
    Route::get('/admin/inventaris/kerusakan', [KerusakanController::class, 'index'])->name('kerusakan.index');
    Route::get('/admin/inventaris/kerusakan/all', [KerusakanController::class, 'all'])->name('kerusakan.all');
    Route::get('/admin/inventaris/kerusakan/{nip}/item', [KerusakanController::class, 'select2item'])->name('kerusakan.select2item');

    Route::get('/admin/inventaris/kerusakan/edit/{id}', [KerusakanController::class, 'edit'])->name('kerusakan.edit');
    Route::get('/admin/inventaris/kerusakan/pdf/{id}', [KerusakanController::class, 'pdf'])->name('kerusakan.pdf');
    Route::post('/admin/inventaris/kerusakan/store', [KerusakanController::class, 'store'])->name('kerusakan.store');
    Route::post('/admin/inventaris/kerusakan/update', [KerusakanController::class, 'update'])->name('kerusakan.update');

    // route stok
    Route::get('/admin/inventaris/stok', [StokController::class, 'index'])->name('stok.index');
    Route::get('/admin/inventaris/stok/all', [StokController::class, 'all'])->name('stok.all');
    Route::get('/admin/inventaris/stok/{kategori_id}/detail', [StokController::class, 'detail'])->name('stok.detail');
    Route::get('/admin/inventaris/stok/{kategori_id}', [StokController::class, 'detailbykategori'])->name('stok.detailbykategori');
    Route::get('/admin/inventaris/stok/{tgl_awal}/{tgl_akhir}/{jenis_data}', [StokController::class, 'detailbytanggal'])->name('stok.detailbytanggal');

    //route stok consumable
    Route::get('/admin/inventaris/stok-consumable', [StokController::class, 'indexConsumable'])->name('stok.indexConsumable');
    Route::get('/admin/inventaris/stok/all/consumable', [StokController::class, 'allconsumable'])->name('stok.allconsumable');

    // route network device
    Route::get('/admin/network-device', [NetworkDeviceController::class, 'index'])->name('networkdevice.index');
    Route::get('/admin/network-device/item/{kode_item}', [NetworkDeviceController::class, 'detailitem'])->name('networkdevice.detailitem');
    Route::get('/admin/network-device/allbyarea', [NetworkDeviceController::class, 'allbyarea'])->name('networkdevice.allbyarea');
    Route::get('/admin/network-device/edit/{id}', [NetworkDeviceController::class, 'edit'])->name('networkdevice.edit');
    Route::get('/admin/network-device/{area_id}/detail-area', [NetworkDeviceController::class, 'detailbyarea'])->name('networkdevice.detailbyarea');
    Route::get('/admin/network-device/{area_id}/detail-area/data', [NetworkDeviceController::class, 'detaildatabyarea'])->name('networkdevice.detaildatabyarea');
    Route::get('/admin/network-device/{area_id}/{lokasi_id}/detail-area/data', [NetworkDeviceController::class, 'detaildatabylokasiarea'])->name('networkdevice.detaildatabylokasiarea');
    
    Route::post('/admin/network-device/update', [NetworkDeviceController::class, 'update'])->name('networkdevice.update');
    Route::post('/admin/network-device/store', [NetworkDeviceController::class, 'store'])->name('networkdevice.store');

    // route area lokasi network device
    Route::get('/admin/area-lokasi', [AreaLokasiController::class, 'index'])->name('arealokasi.index');
        //area
        Route::get('/admin/area-lokasi/all/area', [AreaLokasiController::class, 'allarea'])->name('arealokasi.allarea');
        Route::get('/admin/area-lokasi/{id}/area', [AreaLokasiController::class, 'editarea'])->name('arealokasi.editarea');
        Route::post('/admin/area-lokasi/store/area', [AreaLokasiController::class, 'storearea'])->name('arealokasi.storearea');
        Route::post('/admin/area-lokasi/update/area', [AreaLokasiController::class, 'updatearea'])->name('arealokasi.updatearea');
        Route::post('/admin/area-lokasi/delete/area', [AreaLokasiController::class, 'destroyarea'])->name('arealokasi.deletearea');
        
        //lokasi
        Route::get('/admin/area-lokasi/all/lokasi', [AreaLokasiController::class, 'alllokasi'])->name('arealokasi.alllokasi');
        Route::get('/admin/area-lokasi/{id}/lokasi', [AreaLokasiController::class, 'editlokasi'])->name('arealokasi.editlokasi');
        Route::post('/admin/area-lokasi/update/lokasi', [AreaLokasiController::class, 'updatelokasi'])->name('arealokasi.updatelokasi');
        Route::post('/admin/area-lokasi/store/lokasi', [AreaLokasiController::class, 'storelokasi'])->name('arealokasi.storelokasi');
        Route::post('/admin/area-lokasi/delete/lokasi', [AreaLokasiController::class, 'destroylokasi'])->name('arealokasi.deletelokasi');

    // route backup
    Route::get('/admin/backup', [BackupController::class, 'index'])->name('backup.index');
    Route::get('/admin/backup/data', [BackupController::class, 'backup'])->name('backup.data');

    // route laporan
        //stok
    Route::get('/admin/laporan/stok', [StokController::class, 'laporan'])->name('laporan.stok');
    Route::post('/admin/laporan/stok/export', [StokController::class, 'datalaporan'])->name('laporan.datalaporan');
        // material-request
    Route::get('/admin/laporan/material-request', [PermintaanController::class, 'laporan'])->name('laporan.material-request');
    Route::get('/admin/laporan/material-request/datalaporan/{jenis_laporan}/{tgl_awal}/{tgl_akhir}', [PermintaanController::class, 'datalaporan'])->name('laporan.material-request-datalaporan');
    Route::post('/admin/laporan/material-request/datalaporan/pdf', [PermintaanController::class, 'laporanpdf'])->name('laporan.material-request-laporanpdf');
    Route::post('/admin/laporan/material-request/datalaporan/excel', [PermintaanController::class, 'laporanexcel'])->name('laporan.material-request-laporanexcel');
    Route::post('/admin/laporan/material-request/datalaporan', [PermintaanController::class, 'checklaporan'])->name('laporan.material-request-checklaporan');
        //transaksi
    Route::get('/admin/laporan/transaksi', [LaporanController::class, 'laporantransaksi'])->name('laporan.transaksi');
    Route::get('/admin/laporan/transaksi/export/{jenis_export}/{jenis_transaksi}/{tgl_awal}/{tgl_akhir}', [LaporanController::class, 'exportlaporantransaksi'])->name('laporan.exportlaporantransaksi');
    Route::get('/admin/laporan/transaksi/{jenis_transaksi}/{tgl_awal}/{tgl_akhir}', [LaporanController::class, 'datalaporantransaksi'])->name('laporan.datalaporantransaksi');
    Route::post('/admin/laporan/transaksi', [LaporanController::class, 'checklaporantransaksi'])->name('laporan.checklaporantransaksi');
        //pengguna
    Route::get('/admin/laporan/pengguna', [PenggunaController::class, 'laporan'])->name('laporan.pengguna');
    Route::get('/admin/laporan/pengguna/data', [PenggunaController::class, 'datalaporan'])->name('laporan.datapengguna');
    Route::get('/admin/laporan/pengguna/export/{jenis_export}', [PenggunaController::class, 'export'])->name('laporan.penggunaexport');
    

});

Route::get('/kode', [ItemController::class, 'kodeItem'])->name('item.kode');
// Route::get('/tanggal/{tanggal}', function ()
// {
//     return \TanggalIndo::tanggal_indo('2022-01-10');
// });
Route::get('/ro', [PermintaanController::class, 'ro'])->name('permintaan.ro');
Route::get('/qrcode/{id}', [AdminController::class, 'qrcode'])->name('admin.qrcode');

Auth::routes();
