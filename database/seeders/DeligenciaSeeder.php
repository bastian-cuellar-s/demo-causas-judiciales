<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DeligenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('deligencias')->insert(
            [
                [   
                    'rol'              => 'C-9999-2020',
                    'tribunal'         => 'FAMILIA' ,
                    'materia'          => 'Cuidado Personal',  
                    'caratulado'       => 'CERDA/PEREZ',
                    'obs'        => 'The charm of this car. Choose CIMA. It is the pride and pleasure of choosing one vertex.',
                    'cliente_id'       => '4',
                    'abogado_id'       => '1',
                    'demandado_id'       => '6',
                ],
                [   
                    'rol'              => 'C-9999-2020',
                    'tribunal'         => '1º CIVIL' ,
                    'materia'          => 'Alimentos' ,
                    'caratulado'       => 'CERDA/PEREZ',
                    'obs'        => 'The charm of this car. Choose CIMA. It is the pride and pleasure of choosing one vertex.',
                    'cliente_id'       => '3',
                    'abogado_id'       => '2',
                    'demandado_id'       => '6',
                ],
                [   
                    'rol'              => 'V-99-2019',
                    'tribunal'         => '2º CIVIL',   
                    'materia'          => 'SOLICITUD AUTORIZACIÓN VENTA' ,
                    'caratulado'       => 'CERDA/PEREZ',
                    'obs'        => 'The charm of this car. Choose CIMA. It is the pride and pleasure of choosing one vertex.',
                    'cliente_id'       => '4',
                    'abogado_id'       => '2',
                    'demandado_id'       => '6',
                ],
               
                
            ]
        );
    }
}
