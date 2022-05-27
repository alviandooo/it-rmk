<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemPerbaikan extends Model
{
    use HasFactory;
    protected $table="item_perbaikan";
    protected $guarded=[];

    public function item()
    {
        return $this->hasOne(Item::class, 'kode_item', 'kode_item');
    }

    public function item_service()
    {
        return $this->hasMany(ItemService::class, 'id', 'perbaikan_id');
    }
}
