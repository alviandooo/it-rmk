<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'nip'=>'88888888',
            'name'=>'Super Admin',
            'email'=>'superadmin@rmkenergy.com',
            'role'=>'0',
            'status_aktif'=>'1',
            'password'=>bcrypt('secret'),
        ]);
    }
}
