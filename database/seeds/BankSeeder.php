<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('bank_ve')->insert(
            [
                [
                    "code" => "0001",
                    "name" => "Banco Central de Venezuela",
                    "rif" => "G200001100"
                ],
                [
                    "code" => "0102",
                    "name" => "Banco de Venezuela S.A.C.A. Banco Universal",
                    "rif" => "G200099976"
                ],
                [
                    "code" => "0104",
                    "name" => "Venezolano de Crédito, S.A. Banco Universal",
                    "rif" => "J000029709"
                ],
                [
                    "code" => "0105",
                    "name" => "Banco Mercantil, C.A. Banco Universal",
                    "rif" => "J000029610"
                ],
                [
                    "code" => "0108",
                    "name" => "Banco Provincial, S.A. Banco Universal",
                    "rif" => "J000029679"
                ],
                [
                    "code" => "0114",
                    "name" => "Bancaribe C.A. Banco Universal",
                    "rif" => "J000029490"
                ],
                [
                    "code" => "0115",
                    "name" => "Banco Exterior C.A. Banco Universal",
                    "rif" => "J000029504"
                ],
                [
                    "code" => "0116",
                    "name" => "Banco Occidental de Descuento, Banco Universal C.A",
                    "rif" => "J300619460"
                ],
                [
                    "code" => "0128",
                    "name" => "Banco Caroní C.A. Banco Universal",
                    "rif" => "J095048551"
                ],
                [
                    "code" => "0134",
                    "name" => "Banesco Banco Universal S.A.C.A.",
                    "rif" => "J070133805"
                ],
                [
                    "code" => "0137",
                    "name" => "Banco Sofitasa, Banco Universal",
                    "rif" => "J090283846"
                ],
                [
                    "code" => "0138",
                    "name" => "Banco Plaza, Banco Universal",
                    "rif" => "J002970553"
                ],
                [
                    "code" => "0151",
                    "name" => "BFC Banco Fondo Común C.A. Banco Universal",
                    "rif" => "J000723060"
                ],
                [
                    "code" => "0156",
                    "name" => "100% Banco, Banco Universal C.A.",
                    "rif" => "J085007768"
                ],
                [
                    "code" => "0157",
                    "name" => "DelSur Banco Universal C.A.",
                    "rif" => "J000797234"
                ],
                [
                    "code" => "0163",
                    "name" => "Banco del Tesoro, C.A. Banco Universal",
                    "rif" => "G200051876"
                ],
                [
                    "code" => "0166",
                    "name" => "Banco Agrícola de Venezuela, C.A. Banco Universal",
                    "rif" => "G200057955"
                ],
                [
                    "code" => "0168",
                    "name" => "Bancrecer, S.A. Banco Microfinanciero",
                    "rif" => "J316374173"
                ],
                [
                    "code" => "0169",
                    "name" => "Mi Banco, Banco Microfinanciero C.A.",
                    "rif" => "J315941023"
                ],
                [
                    "code" => "0171",
                    "name" => "Banco Activo, Banco Universal",
                    "rif" => "J080066227"
                ],
                [
                    "code" => "0172",
                    "name" => "Bancamica, Banco Microfinanciero C.A.",
                    "rif" => "J316287599"
                ],
                [
                    "code" => "0174",
                    "name" => "Banplus Banco Universal, C.A",
                    "rif" => "J000423032"
                ],
                [
                    "code" => "0175",
                    "name" => "Banco Bicentenario.",
                    "rif" => "G200091487"
                ],
                [
                    "code" => "0177",
                    "name" => "Banco de la Fuerza Armada Nacional Bolivariana, B.U.",
                    "rif" => "G200106573"
                ],
                [
                    "code" => "0190",
                    "name" => "Citibank N.A.",
                    "rif" => "J000526621"
                ],
                [
                    "code" => "0191",
                    "name" => "Banco Nacional de Crédito, C.A. Banco Universal",
                    "rif" => "J309841327"
                ]
            ]
        );
    }
}
