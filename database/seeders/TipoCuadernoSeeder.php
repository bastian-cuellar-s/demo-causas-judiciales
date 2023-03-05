<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TipoCuadernoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipoCuadernos = [


            [1,'Principal'],
            [2,'Apremio'],
            [3,'Incidente'],
            
            ];
    
            $tipoCuadernos = array_map(function($tipoCuaderno) {
                return [
                    'id' => $tipoCuaderno[0],
                    'name' => $tipoCuaderno[1],
                ];
             }, $tipoCuadernos);
    
             \DB::table('tipo_cuadernos')->insert($tipoCuadernos);
    }
}
