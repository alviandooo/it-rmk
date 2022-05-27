<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemPermintaan extends Model
{
    use HasFactory;

    protected $table='item_permintaan';
    protected $guarded=[];

    public function permintaan()
    {
        return $this->belongsTo(Permintaan::class, 'ro_no', 'ro_no');
    }

    public function satuan()
    {
        return $this->belongsTo(Satuan::class, 'uom', 'id');
    }
}
