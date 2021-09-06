<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JornadaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('hipodromos')->insert(
            [
                [
                 'name' => 'LA RINCONADA',
                 'status' => 1
                ]
            ]
        );

        DB::table('tab_poles')->insert(
            [
                [
                    'ini_monto' => 0,
                    'end_monto' => 0,
                    'value' => 0
                ],
                [
                 'ini_monto' => 500000,
                 'end_monto' => 1000000,
                 'value' => 500000
                ],
                [
                    'ini_monto' => 1000000,
                    'end_monto' => 8000000,
                    'value' => 1000000000
                ],
                [
                    'ini_monto' => 8000000,
                    'end_monto' => 16000000,
                    'value' => 2000000000
                ]
            ]
        );
    }
}
