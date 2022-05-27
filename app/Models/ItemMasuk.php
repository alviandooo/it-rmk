<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Awobaz\Compoships\Compoships;

class ItemMasuk extends Model
{
    use \Awobaz\Compoships\Compoships;

    use HasFactory;
    protected $table="item_masuk";
    protected $guarded=[];

    public function item()
    {
        return $this->hasOne(Item::class, 'kode_item', 'kode_item');
    }

    public function item_keluar()
    {
        return $this->belongsto(ItemKeluar::class, ['kode_item','nip'], ['kode_item','nip']);
    }
}
