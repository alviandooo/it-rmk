<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kategori = ['LAPTOP','PRINTER','PC','NETWORK DEVICE','PERIPHERALS','CONSUMABLE'];
        $kode = ['L','P','PC','ND','PH','CO'];
        for ($i=0; $i < 6; $i++) { 
            DB::table('kategori')->insert([
                'kategori'=>$kategori[$i],
                'kode'=>$kode[$i],
            ]);
        }
    }
}
