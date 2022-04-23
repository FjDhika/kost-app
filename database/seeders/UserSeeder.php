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
            'name' => 'owner',
            'email' => 'owner@gmail.com',
            'role_id' => 1,
            'password' => bcrypt('owner@password'),
        ]);

        DB::table('users')->insert([
            'name' => 'regular_user',
            'email' => 'regular_user@gmail.com',
            'role_id' => 2,
            'token' => 20,
            'password' => bcrypt('regular_user@password'),
        ]);

        DB::table('users')->insert([
            'name' => 'premium_user',
            'email' => 'premium_user@gmail.com',
            'role_id' => 3,
            'token' => 40,
            'password' => bcrypt('premium_user@password'),
        ]);
    }
}
