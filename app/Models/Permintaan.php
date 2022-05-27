<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Awobaz\Compoships\Compoships;

class Permintaan extends Model
{
    use \Awobaz\Compoships\Compoships;

    use HasFactory;

    protected $table='permintaan';
    protected $guarded=[];

    public function item_permintaan()
    {
        return $this->hasMany(ItemPermintaan::class, 'ro_no', 'ro_no');
    }

    public function permintaan_material()
    {
        return $this->hasOne(ItemPermintaan::class);
    }

    public function approval()
    {
        return $this->hasMany(Approval::class,'dokumen_id','id');
    }

}
