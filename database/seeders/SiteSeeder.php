<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class SiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('site')->insert([
            'kode_perusahaan'=>'RMKE',
            'nama_perusahaan'=>'PT RMK Energy Tbk',
            'lokasi_perusahaan'=>'MUSI 2',
            'alamat_perusahaan'=>'Palembang',
        ]);
    }
}
