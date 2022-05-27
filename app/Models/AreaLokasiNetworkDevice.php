<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreaLokasiNetworkDevice extends Model
{
    use HasFactory;

    protected $table="area_lokasi_network_device";
    protected $guarded=[];

    public function lokasi_network_device()
    {
        return $this->hasMany(LokasiNetworkDevice::class, 'id', 'area_lokasi_network_device_id');
    }
}
