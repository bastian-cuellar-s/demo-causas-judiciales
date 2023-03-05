<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('gestiones')->insert(
            [
                [   
                    'encargo'          => 'Embargo' ,
                    'cuaderno'         => 'principal' ,
                    'estampe'          => null,  
                    'correo'           => null,   
                    'cobrado'           => null,   
                    'pagado'           => null,   
                    'f_estampado'      => '2021/03/30' ,
                    'resultado'        => 'The charm of this car. Choose CIMA. It is the pride and pleasure of choosing one vertex.',
                    'deligencia_id'       => '1',
                ],
                [   
                    'encargo'          => 'Embargo' , 
                    'cuaderno'         => 'principal' , 
                    'estampe'          => null,  
                    'correo'           => null,   
                    'cobrado'           => null,   
                    'pagado'           => null,   
                    'f_estampado'      => '2021/03/30' ,
                    'resultado'              => 'The charm of this car. Choose CIMA. It is the pride and pleasure of choosing one vertex.',
                    'deligencia_id'       => '2',
                ],
                [   
                    'encargo'          => 'Embargo' ,
                    'cuaderno'         => 'principal' , 
                    'estampe'          => null,  
                    'correo'           => null,   
                    'cobrado'           => null,   
                    'pagado'           => null,   
                    'f_estampado'      => '2021/03/30' ,
                    'resultado'              => 'The charm of this car. Choose CIMA. It is the pride and pleasure of choosing one vertex.',
                    'deligencia_id'       => '3',
                ],
               
                
            ]
        );
    }
}
