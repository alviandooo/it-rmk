<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use HasFactory;
    protected $table="site";
    protected $guarded=[];

    public function user()
    {
        return $this->hasMany(User::class, 'lokasi','id');
    }

    public function item()
    {
        return $this->hasMany(User::class, 'lokasi','id');
    }
}
