<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PersonaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('personas')->insert(
            [
                [   

                    'name'             => 'Carlos Edmundo',
                    'APaterno'         => 'Perez', 
                    'AMaterno'         => 'Muñoz',  
                    'rut'              => '10.000.000-9', 
                    'email'            => 'prueba@mail.com',
                    'telefono'         => '999999',
                    'obs'              => 'The charm of this car. Choose CIMA. It is the pride and pleasure of choosing one vertex.',
                    'representante'     => null,
                    'tipo_persona'     => 'natural',
                    'funcion'           => 'abogado',
                ],
                [   

                    'name'             => 'Belen Andrea',
                    'APaterno'         => 'Arriagada', 
                    'AMaterno'         => 'Jimenez',  
                    'rut'              => '9.999.999-9', 
                    'email'            => 'belen.andrea@mail.com',
                    'telefono'         => '9999999999',
                    'obs'              => 'The charm of this car. Choose CIMA. It is the pride and pleasure of choosing one vertex.',
                    'representante'     => null,
                    'tipo_persona'     => 'natural',
                    'funcion'           => 'abogado',
                ],
                [   

                    'name'             => 'Bastian Daniel',
                    'APaterno'         => 'Sanchez', 
                    'AMaterno'         => 'Espinoza',  
                    'rut'              => '19.111.111-2' ,
                    'email'            => 'bastian.sanchez@mail.com',
                    'telefono'         => '9123123123',
                    'obs'              => 'The charm of this car. Choose CIMA. It is the pride and pleasure of choosing one vertex.',
                    'representante'     => null,
                    'tipo_persona'     => 'natural',
                    'funcion'           => 'cliente',
                ],
                [   

                    'name'             => 'Banco estado' ,
                    'APaterno'         => null, 
                    'AMaterno'         => null,   
                    'rut'              => '88.998.393-0', 
                    'email'            => 'banco.estado@gmail.com',
                    'telefono'         => '983267652',
                    'obs'              => 'The charm of this car. Choose CIMA. It is the pride and pleasure of choosing one vertex.',
                    'representante'    => 'Alberto Alejandro Cea Cea',
                    'tipo_persona'     => 'juridica',
                    'funcion'           => 'cliente',
                ],
                [   

                    'name'             => 'Lider' ,
                    'APaterno'         => null, 
                    'AMaterno'         => null,    
                    'rut'              => '91.625.393-0', 
                    'email'            => 'lider.empresa@gmail.com',
                    'telefono'         => '8297323121',
                    'obs'              => 'The charm of this car. Choose CIMA. It is the pride and pleasure of choosing one vertex.',
                    'representante'    => 'Aguero Velasquez Jaime',
                    'tipo_persona'     => 'juridica',
                    'funcion'           => 'cliente',
                ],
                [   

                    'name'             => 'Jaime Antonio',  
                    'rut'              => '7.380.453-1',
                    'APaterno'         => 'Aguilera', 
                    'AMaterno'         => 'Roa',   
                    'email'            => 'jaime.antonio@gmail.com',
                    'telefono'         => '90838112112',
                    'obs'              => 'The charm of this car. Choose CIMA. It is the pride and pleasure of choosing one vertex.',
                    'representante'    => 'Alberto Alejandro Cea Cea',
                    'tipo_persona'     => 'natural',
                    'funcion'           => 'demandado',
                ],
                [   

                    'name'             => 'Flox SPA',  
                    'rut'              => '71.999.111-2',
                    'APaterno'         => null, 
                    'AMaterno'         => null,   
                    'email'            => 'flox.spa@gmail.com',
                    'telefono'         => '9346212112',
                    'obs'              => 'The charm of this car. Choose CIMA. It is the pride and pleasure of choosing one vertex.',
                    'representante'    => 'Kevin Alejandro Boloco',
                    'tipo_persona'     => 'juridica',
                    'funcion'           => 'demandado',
                ],
                
            ]
        );
    }
}
