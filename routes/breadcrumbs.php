<?php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// dashboard
Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('admin.dashboard'));
});

//laporan
//laporan > stok
Breadcrumbs::for('laporan-stok', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Laporan / Stok', route('laporan.stok'));
});

//laporan > material request
Breadcrumbs::for('laporan-material-request', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Laporan / Material Request', route('laporan.material-request'));
});

//laporan > transaksi
Breadcrumbs::for('laporan-transaksi', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Laporan / Transaksi ', route('laporan.transaksi'));
});

//laporan > pengguna
Breadcrumbs::for('laporan-pengguna', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Laporan / Pengguna ', route('laporan.pengguna'));
});

//inventaris
//inventaris > masuk
Breadcrumbs::for('inventaris-masuk', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Inventaris / Masuk', route('itemmasuk.index'));
});

//inventaris > keluar
Breadcrumbs::for('inventaris-keluar', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Inventaris / Keluar', route('itemkeluar.index'));
});

//inventaris > perbaikan
Breadcrumbs::for('inventaris-perbaikan', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Inventaris / Perbaikan', route('itemperbaikan.index'));
});

//inventaris > permintaan
Breadcrumbs::for('inventaris-permintaan', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Inventaris / Permintaan', route('permintaan.index'));
});

//inventaris > permintaan > Approve
Breadcrumbs::for('inventaris-permintaan-approve', function (BreadcrumbTrail $trail) {
    $trail->parent('inventaris-permintaan');
    $trail->push('Approve', route('permintaan.indexapprove'));
});

//inventaris > permintaan > Create
Breadcrumbs::for('inventaris-permintaan-create', function (BreadcrumbTrail $trail) {
    $trail->parent('inventaris-permintaan');
    $trail->push('Create', route('permintaan.tambah'));
});

//inventaris > permintaan > Edit
Breadcrumbs::for('inventaris-permintaan-edit', function (BreadcrumbTrail $trail) {
    $trail->parent('inventaris-permintaan');
    $trail->push('Edit', route('permintaan.tambah'));
});

//inventaris > kerusakan
Breadcrumbs::for('inventaris-kerusakan', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Inventaris / Kerusakan', route('kerusakan.index'));
});

//kategori Item
//Kategori > laptop
Breadcrumbs::for('kategori-laptop', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Inventory / laptop', route('item.laptop'));
});

//Kategori > printer
Breadcrumbs::for('kategori-printer', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Inventory / Printer', route('item.printer'));
});

//Kategori > pc
Breadcrumbs::for('kategori-pc', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Inventory / PC', route('item.pc'));
});

//Kategori > network device
Breadcrumbs::for('kategori-nd', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Inventory / Network Device', route('item.nd'));
});

//Kategori > Consumable
Breadcrumbs::for('kategori-consumable', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Inventory / Consumable', route('item.consumable'));
});

//Kategori > peripheral
Breadcrumbs::for('kategori-peripheral', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Inventory / Peripheral', route('item.peripheral'));
});

//master data
//item
//Dashboard > Item
Breadcrumbs::for('item', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Data Item', route('item.index'));
});

//Dashboard > Item > Edit
Breadcrumbs::for('item-detail', function (BreadcrumbTrail $trail) {
    $trail->parent('item');
    $trail->push('Detail Data Item', route('item.index'));
});

//Dashboard > Area & lokasi
Breadcrumbs::for('area-lokasi-device', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Data Area & Lokasi Device', route('arealokasi.index'));
});

//Dashboard > SAP Item
Breadcrumbs::for('sap-item', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Data SAP Item Device', route('sap.index'));
});

//Dashboard > Site
Breadcrumbs::for('site', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Data Site', route('site.index'));
});

//Kategori
//Dashboard > Kategori Item
Breadcrumbs::for('kategori', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Data Kategori', route('kategori.index'));
});

//Unit of Material
//Dashboard > Unit of Material
Breadcrumbs::for('uom', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Data Unit of Material', route('satuan.index'));
});

//User
//Dashboard > Users
Breadcrumbs::for('users', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Data Users', route('user.index'));
});

//Network Device
//Dashboard > Network Device
Breadcrumbs::for('network-device', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Data Network Device', route('networkdevice.index'));
});

//Dashboard > Network Device > {{area}}
Breadcrumbs::for('network-device-area', function (BreadcrumbTrail $trail, $area) {
    $trail->parent('network-device');
    $trail->push('Data Network Device Area '.$area , route('networkdevice.index'));
});

//Pengguna Aset
//Dashboard > Pengguna Aset
Breadcrumbs::for('pengguna', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Data Pengguna Aset', route('pengguna.index'));
});

//Dashboard > Pengguna Aset > Nama
Breadcrumbs::for('pengguna-detail', function (BreadcrumbTrail $trail, $nama) {
    $trail->parent('pengguna');
    $trail->push( $nama, route('pengguna.index'));
});

//Stok Aset
//Dashboard > Stok Aset
Breadcrumbs::for('stok', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Data Stok Aset', route('stok.index'));
});

//Dashboard > Stok Aset >{{kategori}}
Breadcrumbs::for('stok-kategori', function (BreadcrumbTrail $trail, $kategori) {
    $trail->parent('stok');
    $trail->push($kategori, route('stok.index'));
});

//Dashboard > Stok Aset Consumable
Breadcrumbs::for('stok-consumable', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Data Stok Aset Consumable', route('stok.indexConsumable'));
});


//Dashboard > Stok Aset >{{kategori}}
Breadcrumbs::for('stok-kategori-consumable', function (BreadcrumbTrail $trail, $kategori) {
    $trail->parent('dashboard');
    $trail->push($kategori, route('stok.indexConsumable'));
});


// // Home > Blog > [Category]
// Breadcrumbs::for('category', function (BreadcrumbTrail $trail, $category) {
//     $trail->parent('blog');
//     $trail->push($category->title, route('category', $category));
// });