<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Awobaz\Compoships\Compoships;

class Approval extends Model
{
    use \Awobaz\Compoships\Compoships;

    use HasFactory;

    protected $table="approval";
    protected $guarded=[];

    public function permintaan()
    {
        return $this->belongsTo(Permintaan::class,'id','dokumen_id');
    }

}
