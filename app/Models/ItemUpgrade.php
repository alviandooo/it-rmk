<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemUpgrade extends Model
{
    use HasFactory;

    protected $table="item_upgrade";
    protected $guarded=[];

    public function item()
    {
        return $this->belongsTo(Item::class, 'kode_item', 'kode_item');
    }

    public function item_part()
    {
        return $this->hasMany(Item::class,'kode_item',  'kode_item_upgrade');
    }
}
