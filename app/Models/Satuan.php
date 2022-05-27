<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Satuan extends Model
{
    use HasFactory;

    protected $table="satuan";
    protected $guarded=[];

    public function item()
    {
        return $this->hasMany(Item::class);
    }

    public function item_permintaan()
    {
        return $this->hasMany(ItemPermintaan::class, 'id', 'uom');
    }
}
