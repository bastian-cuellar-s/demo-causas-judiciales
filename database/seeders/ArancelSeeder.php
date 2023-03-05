<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ArancelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('aranceles')->insert(
            [
                [   
                    'name'    => 'Busqueda Negativa',
                    'valor'       => '10000',
                    'persona_id'   => '1',
                ],
                [   
                    'name'    => 'Cedula Adulta Art 44',
                    'valor'       => '5000',
                    'persona_id'   => '1',
                ],
                [   
                    'name'    => 'Embargo Cuenta Corriente',
                    'valor'       => '8000',
                    'persona_id'   => '1',
                ],
                [   
                    'name'    => 'Busqueda Negativa',
                    'valor'       => '10000',
                    'persona_id'   => '2',
                ],
                [   
                    'name'    => 'Cedula Adulta Art 44',
                    'valor'       => '5000',
                    'persona_id'   => '2',
                ],
                [   
                    'name'    => 'Embargo Cuenta Corriente',
                    'valor'       => '8000',
                    'persona_id'   => '2',
                ],
            ]
        );
    }
}
