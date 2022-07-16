<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $table="item";
    protected $guarded=[];

    public function satuan()
    {
        return $this->belongsTo(Satuan::class);
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function item_masuk()
    {
        return $this->belongsTo(ItemMasuk::class);
    }

    public function item_keluar()
    {
        return $this->belongsTo(ItemKeluar::class, 'kode_item','kode_item');
    }

    public function item_perbaikan()
    {
        return $this->belongsTo(ItemPerbaikan::class,'kode_item','kode_item');
    }

    public function kerusakan()
    {
        return $this->belongsTo(Kerusakan::class, 'kode_item', 'kode_item');
    }

    public function network_device()
    {
        return $this->hasOne(NetworkDevice::class, 'kode_item', 'kode_item');
    }

    public function item_upgrade()
    {
        return $this->hasMany(ItemUpgrade::class, 'kode_item', 'kode_item');
    }

    public function item_upgrade_part()
    {
        return $this->belongsTo(ItemUpgrade::class, 'kode_item_upgrade', 'kode_item');
    }

    public function item_site()
    {
        return $this->belongsTo(Site::class, 'site','id');
    }
}
