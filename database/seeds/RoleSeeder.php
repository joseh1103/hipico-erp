<?php

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
        DB::table('roles')->insert(
            [
                [
                'name' => 'Super Admin',
                ],
                [
                'name' => 'Jugador',
                ]
            ]
        );
/*
        DB::table('permissions')->insert(
            [
                [
                    'name'          =>   'Leer(read)',
                ],
                [
                    'name'          =>   'Modificar(update)',
                ],
                [
                    'name'          =>   'Crear(create)',
                ],
                [
                    'name'          =>   'Eliminar(delete)',
                ]
            ]

        );
        
        DB::table('role_has_permissions')->insert(
            // super admin
            [
                [
                    'permission_id'    => 1,
                    'role_id'           => 1,
                ],
                [
                    'permission_id'    => 2,
                    'role_id'           => 1,
                ],
                [
                    'permission_id'    => 3,
                    'role_id'           => 1,
                ],
                [
                    'permission_id'    => 4,
                    'role_id'           => 1,
                ],

            ],
            
    );*/
    }
}
