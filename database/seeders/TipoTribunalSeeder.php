<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TipoTribunalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $tribunales = [

        [1,'1º juzgado civil Talcahuano'],
        [2,'2º juzgado civil Talcahuano.'],
        [3,'Juzgado de Cobranza Laboral y Previsional de Concepción.'],
        [4,'Juzgado de Garantía Talcahuano.'],
        [5,'Juzgado de Familia Talcahuano.'],
        [6,'1º juzgado PoliciaLocal Talcahuano'],
        [7,'2º juzgado Policia Local Talcahuano.'],
        [8,'Juzgado Policia Local Hualpen.'],
        [9,'Otros Tribunales.'],
        
        ];

        $tribunales = array_map(function($tribunal) {
            return [
                'id' => $tribunal[0],
                'name' => $tribunal[1],
            ];
         }, $tribunales);

         \DB::table('tribunales')->insert($tribunales);

    }
}
