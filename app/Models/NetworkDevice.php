<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NetworkDevice extends Model
{
    use HasFactory;

    protected $table="network_device";
    protected $guarded=[];

    public function lokasi_network_device()
    {
        return $this->belongsTo(LokasiNetworkDevice::class, 'lokasi_network_device_id', 'id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'kode_item', 'kode_item');
    }
}
