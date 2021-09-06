<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('currency')->insert(
            [
                [
                'name' => 'Bolivares',
                 'symbol' => 'Bs'
                ],
                [
                 'name' => 'Dolares ',
                 'symbol' => 'USD$'
                ],
                [
                'name' => 'PEN ',
                'symbol' => 'S/'
                ]
            ]
        );

        DB::table('jugadas')->insert(
            [
                [
                'name' => '1-P',
                'description' => 'En esta jugada el que recibe la misma deberá ligar que el ejemplar apostado pase la raya de primer lugar obteniendo como ganancia lo apostado menos comisión. De llegar en el segundo lugar perderá tod'
                ],
                [
                'name' => '2-P',
                'description' => 'En esta jugada el que recibe la misma deberá ligar que el ejemplar apostado pase la raya de primer o segundo lugar obteniendo como ganancia lo apostado menos comisión. De llegar en el tercer lugar perderá todo.'
                ],
                [
                'name' => '3-P',
                'description' => 'En esta jugada el que recibe la misma deberá ligar que el ejemplar apostado pase la raya de entre los 3 primeros lugar obteniendo como ganancia lo apostado menos comisión. De llegar en el cuarto lugar perderá todo.'
                ],
                [
                'name' => '4-P',
                'description' => 'En esta jugada el que recibe la misma deberá ligar que el ejemplar apostado pase la raya de entre los 4 primeros lugar obteniendo como ganancia lo apostado menos comisión. De llegar en el quinto lugar perderá todo.'
                ],
                [
                'name' => 'Pizarra',
                'description' => 'En esta jugada el que recibe la misma deberá ligar que el ejemplar apostado pase la raya de entre los 5 primeros lugar'
                ],
                [
                'name' => 'Dos NINI (2NN)',
                'description' => 'En esta jugada el que recibe la misma deberá ligar que el ejemplar apostado pase la raya de primer lugar para obtener como ganancia lo apostado menos comisión, si pasa la raya en el segundo lugar recupera su inversión. De llegar en el tercer lugar perderá todo'
                ],
                [
                'name' => '1-Puesto y 2 nini',
                'description' => 'En esta jugada el que recibe la misma deberá ligar que el ejemplar apostado pase la raya de primer lugar para obtener como ganancia lo apostado menos comisión, de llegar en el segundo lugar pierde la mitad de lo apostado, dándole al ganador el monto ganado menos comisión. De llegar en el tercer lugar perderá todo.'
                ],
                [
                'name'=> 'Dos puestos y dos nini (2y2)',
                'description' => 'En esta jugada el que recibe la misma deberá ligar que el ejemplar apostado pase la raya de primer lugar para obtener como ganancia lo apostado menos comisión, de llegar en el segundo lugar obtendrá como ganancia la mitad de lo apostado menos comisión. En caso de llegar en el tercer lugar perderá todo.'
                ],
                [
                'name' => 'Jugadas 10 a',
                'description' => 'En esta apuesta el jugado que acepta la misma juega según proporción que indica el que la está dando, por ejemplo: Manuel da 10 a 5 de Pedro Caimán a Leonardo con 500.000,00.'
                ],
                [
                'name' => 'Jugadas pelo a pelo',
                'description' => 'En esta jugada usted apuesta por un ejemplar contra otro ejemplar que lleva su oponente. Se tomara en cuenta los 5 primeros puestos de la pizarra de no tomar pizarra ninguno de los 2 ejemplares  que están en juego se considera la parada o apuesta nula y se le retornara los montos apostados a cada jugador(OJO es como de él orden oficial de la carrera)'
                ],
                [
                'name' => 'Jugadas de morochas o tripochas',
                'description' => 'En el caso de morocha contra morocha (2 caballos contra 2 caballos) si existe un retiro de alguno de los 4 participantes la parada no va y no se descuenta porcentaje. En el caso de tripochas (3 caballos contra 3 caballos) aplica la misma regla de la morocha. Se tomara en cuenta los 5 primeros lugares de la pizarra y el orden oficial de la carrera'
                ],
                [
                'name' => '2y3',
                 'description' => ''
                ],
                [
                 'name' => '3y3',
                 'description' => ''
                ]
            ]
        );
    }
}
