<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DomicilioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('domicilios')->insert(
            [
                [   
                    'direccion'    => 'Frutillar  Nueva Alemania',
                    'numero'       => '3542', 
                    'complemento'  => 'B-102', 
                    'comuna'       => 'Calama',  
                    'region'       => 'Antofagasta', 
                    'negativa'     => null, 
                    'obs'          => 'The charm of this car. Choose CIMA. It is the pride and pleasure of choosing one vertex.',
                    'persona_id'   => '1',
                ],
                [   
                    'direccion'    => 'Nueva Uno  Pb La Faena',
                    'numero'       => '7096' ,
                    'complemento'  => null, 
                    'comuna'       => 'Peñalolen' , 
                    'region'       => 'Región Metropolitana de Santiago' ,
                    'negativa'     => null, 
                    'obs'          => 'The charm of this car. Choose CIMA. It is the pride and pleasure of choosing one vertex.',
                    'persona_id'   => '2',
                ],
                [   
                    'direccion'    => 'Caupolican',
                    'numero'       => '528' ,
                    'complemento'  => null, 
                    'comuna'       => 'Los Vilos'  ,
                    'region'       => 'Coquimbo' ,
                    'negativa'     => null,
                    'obs'          => 'The charm of this car. Choose CIMA. It is the pride and pleasure of choosing one vertex.',
                    'persona_id'   => '3',
                ],
                [   
                    'direccion'    => 'Guillermo Edwars  El Llano',
                    'numero'       => '250',
                    'complemento'  => null,  
                    'comuna'       => 'Coquimbo',  
                    'region'       => 'Coquimbo',
                    'negativa'     => null, 
                    'obs'          => 'The charm of this car. Choose CIMA. It is the pride and pleasure of choosing one vertex.',
                    'persona_id'   => '4',
                ],
                [   
                    'direccion'    => 'Psje Koyan  Cia Alta',
                    'numero'       => '3325' ,
                    'complemento'  => null, 
                    'comuna'       => 'Las Compañias' , 
                    'region'       => 'Antofagasta',
                    'negativa'     => null, 
                    'obs'          => 'The charm of this car. Choose CIMA. It is the pride and pleasure of choosing one vertex.',
                    'persona_id'   => '5',
                ],
                [   
                    'direccion'    => 'Antofagasta ',
                    'numero'       => '335',
                    'complemento'  => 'B-102',  
                    'comuna'       => 'Ovalle',  
                    'region'       => 'Coquimbo' ,
                    'negativa'     => null,
                    'obs'          => 'The charm of this car. Choose CIMA. It is the pride and pleasure of choosing one vertex.',
                    'persona_id'   => '6',
                ],
                
                
            ]
        );
    }
}
