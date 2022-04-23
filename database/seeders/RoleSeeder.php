<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'role_name'=>'owner',
            'role_slug' => 'owner'
        ]);

        DB::table('roles')->insert([
            'role_name'=>'regular',
            'role_slug' => 'regular'
        ]);

        DB::table('roles')->insert([
            'role_name'=>'premium',
            'role_slug' => 'premium'
        ]);
    }
}
