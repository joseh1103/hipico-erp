<?php

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
        DB::table('setting')->insert([
            'min_poso' => '5000000',
            'min_retiro' => '5000000'
        ]);
        DB::table('users')->insert(
            [
                [
                    'name' => 'Casa 2020',
                    'user' => 'Casa',
                    'email' => 'casa.h@hipico2020.com',
                    'password' => bcrypt('hipico@20201.'),
                    'phone' => '04128763843',
                    'role_id' => 2,
                    'status' => 1,
                    'country' => '+58'
                ],
                [
                    'name' => 'Jose Hernandez',
                    'user' => 'Joseh1103',
                    'email' => 'jose.h@hipico2020.com',
                    'password' => bcrypt('hipico@20201.'),
                    'phone' => '04128763843',
                    'role_id' => 1,
                    'status' => 1,
                    'country' => '+58'
                ],
                [
                    'name' => 'Alexander',
                    'user' => 'alexander',
                    'email' => 'alexander.p@hipico2020.com',
                    'password' => bcrypt('hipico@20201.'),
                    'phone' => '333333333',
                    'role_id' => 1,
                    'status' => 1,
                    'country' => '+58'
                ],
                [
                    'name' => 'Jose',
                    'user' => 'Hernandez',
                    'email' => 'josemanuel.h.1103@gmail.com',
                    'password' => bcrypt('V21111643..'),
                    'phone' => '584128763843',
                    'role_id' => 2,
                    'status' => 1,
                    'country' => '+58'
                ]
            ]
        );
    }
}
