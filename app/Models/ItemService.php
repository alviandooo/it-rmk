<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemService extends Model
{
    use HasFactory;

    protected $table="item_service";
    protected $guarded=[];

    public function item_perbaikan()
    {
        return $this->belongsTo(ItemPerbaikan::class, 'perbaikan_id', 'id');
    }

    public function item_keluar()
    {
        return $this->belongsTo(ItemPerbaikan::class, 'kode_item', 'kode_item_service');
    }
}
