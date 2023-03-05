<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TipoEncargoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $encargos = [


        [1,'Búsquedas'],
        [2,'Notificación y requerimiento de pago'],
        [3,'Embargo'],
        [4,'Embargo vehículos e inmuebles'],
        [5,'Embargo con fuerza pública'],
        [6,'Retiro especies'],
        [7,'Retiro especies con fuerza pública'],
        [8,'Certificación'],
        [9,'Notificación protesto de cheque'],
        [10,'Notificación por cédula'],
        [11,'Lanzamientos'],
        [12,'informacion sumaria de testigos'],
        [13,'Testimonial'],
        [14,'absolución de posiciones'],
        [15,'Tramitacion de exhorto'],

        ];

        $encargos = array_map(function($encargo) {
            return [
                'id' => $encargo[0],
                'name' => $encargo[1],
            ];
         }, $encargos);

         \DB::table('encargos')->insert($encargos);


    }
}
