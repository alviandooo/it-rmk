<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Awobaz\Compoships\Compoships;

class ItemKeluar extends Model
{
    use \Awobaz\Compoships\Compoships;

    use HasFactory;
    protected $table="item_keluar";
    protected $guarded=[];

    public function item()
    {
        return $this->hasOne(Item::class, 'kode_item', 'kode_item');
    }

    public function item_service()
    {
        return $this->hasMany(ItemService::class, 'kode_item_service', 'kode_item');
    }

    public function item_masuk()
    {
        return $this->hasOne(ItemMasuk::class, ['kode_item','nip'], ['kode_item','nip']);
    }

    
}
