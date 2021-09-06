<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MethedoPaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payment_methods')->insert(
            [
                [
                    "typePayment" => "Transferencia",
                    "typeDocument" => "V",
                    "document" => "21.111.643",
                    "name_beneficiary" => "Jose Hernandez",
                    "account_number"=> "0134-0361-9536-1103-3074",
                    "code_bank"=> "0134",
                    "phone"=> "0412-876-3843",
                    "currency_id"=> 1,
                ],
                [
                    "typePayment" => "Transferencia",
                    "typeDocument" => "V",
                    "document" => "21.111.643",
                    "name_beneficiary" => "Jose Hernandez",
                    "account_number"=> "0105-0064-8210-6457-2944",
                    "code_bank"=> "0105",
                    "phone"=> "0412-876-3843",
                    "currency_id"=> 1,
                ],
                [
                    "typePayment" => "Transferencia",
                    "typeDocument" => "V",
                    "document" => "12.376.263",
                    "name_beneficiary" => "Alexander Pellegrini",
                    "account_number"=> "0116-0034-4300-0003-0742",
                    "code_bank"=> "0116",
                    "phone"=> "0414-105-9565",
                    "currency_id"=> 1,
                ],
                [
                    "typePayment" => "Transferencia",
                    "typeDocument" => "V",
                    "document" => "12.376.263",
                    "name_beneficiary" => "Alexander Pellegrini",
                    "account_number"=> "0163-0900-1990-0509-0253",
                    "code_bank"=> "0163",
                    "phone"=> "0414-105-9565",
                    "currency_id"=> 1,
                ],
                [
                    "typePayment" => "Transferencia",
                    "typeDocument" => "V",
                    "document" => "12.007.406",
                    "name_beneficiary" => "Maria muñoz",
                    "account_number"=> "0108-0076-5902-0049-2050",
                    "code_bank"=> "0108",
                    "phone"=> "0412-878-1396",
                    "currency_id"=> 1,
                ],
               
            ]
        );
    }
}
