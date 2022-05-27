<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LokasiNetworkDevice extends Model
{
    use HasFactory;

    protected $table="lokasi_network_device";
    protected $guarded=[];

    public function area_lokasi_network_device()
    {
        return $this->belongsTo(AreaLokasiNetworkDevice::class, 'area_lokasi_network_device_id', 'id');
    }
    
    public function network_device()
    {
        return $this->hasMany(NetworkDevice::class, 'id', 'lokasi_network_device_id');
    }
}
