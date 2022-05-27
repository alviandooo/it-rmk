<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kerusakan extends Model
{
    use HasFactory;

    protected $table="kerusakan";
    protected $guarded=[];

    public function item()
    {
        return $this->hasOne(Item::class, 'kode_item', 'kode_item');
    }
}
