<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            // SuperAdmin
            [
                'name' =>  'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('password'),
                'role_id' => '1',
            ],

            //Gudang
            [
                'name' =>  'Gudang',
                'email' => 'gudang@gmail.com',
                'password' => Hash::make('password'),
                'role_id' => '2',
            ],
        ]);

        DB::table('user_roles')->insert([
            [
                'role_name' => 'Super Admin',
            ],
            [
                'role_name' => 'Gudang',
            ],
        ]);
    }
}
