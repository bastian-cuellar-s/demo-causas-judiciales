<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TipoArancelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $aranceles = [

                        
            [1,'Alzamiento Medida Precautoria'],
            [2,'Alzamiento Propiedad'],
            [3,'Alzamiento Vehiculo'],
            [4,'Ampliacion Embargo'],
            [5,'Ampliacion Embargo Retiro Fuerza Publica'],
            [6,'Busqueda Frutrada'],
            [7,'Busqueda Negativa'],
            [8,'Busqueda Positiva'],
            [9,'Cedula Adulta'],
            [10,'Cedula Adulta Art 44'],
            [11,'Cedula Adulta Art 44 Mandamiento'],
            [12,'Cedula Adulta Art 46 Abogado'],
            [13,'Cedula Adulta Mandamiento CE'],
            [14,'Cedula Cheque Fija'],
            [15,'Cedula Cheque Fija Nego'],
            [16,'Cedula Cheque Persona Adulta'],
            [17,'Cedula Espera'],
            [18,'Cedula Fija'],
            [19,'Cedula Fija Art 44'],
            [20,'Cedula Fija Art 44 Mandamiento'],
            [21,'Cedula Fija Art 44 y Abogado'],
            [22,'Cedula Fija Mandamiento CE'],
            [23,'Cedula Fija Nego'],
            [24,'Citacion Testigo'],
            [25,'Descerrajamiento'],
            [26,'Edificio Departamentos'],
            [27,'Embargo Cuenta Corriente'],
            [28,'Embargo Frutrado Fuerza Publica'],
            [29,'Embargo Frutrado sin Fuerza Publica'],
            [30,'Embargo Fuerza Publica'],
            [31,'Embargo Fuerza Publica Descerrajamiento'],
            [32,'Embargo Fuerza Publica Descerrajamiento Frustrado'],
            [33,'Embargo Propiedad'],
            [34,'Embargo sin Fuerza Publica'],
            [35,'Embargo  Vehiculo'],
            [36,'Fallecio'],
            [37,'Gastos Conservador'],
            [38,'Incautacion'],
            [39,'Informacion Sumaria Testigos'],
            [40,'Lanzamiento'],
            [41,'Medida Precautoria'],
            [42,'Notificacion Acc Hip Ley Banco'],
            [43,'Notificacion Art 431 Embargo'],
            [44,'Notificacion Art 431 Op Embargo'],
            [45,'Notificacion Art 44 Acc Hip Ley Banco'],
            [46,'Notificacion Art 44 Req Op Embargo'],
            [47,'Notificacion Art 44 Serviu'],
            [48,'Notificacion Auto Prueba'],
            [49,'Notificacion Cedula Adulta Art 44 Hipotecaria'],
            [50,'Notificacion Cedula Fija Art 44 Hipotecaria'],
            [51,'Notificacion Demanda Ejecutiva Op Embargo'],
            [52,'Notificacion Desposeimiento'],
            [53,'Notificacion Extravio al Banco'],
            [54,'Notificacion Personal '],
            [55,'Notificacion Personal Cheque'],
            [56,'Notificacion Personal Conservador'],
            [57,'Notificacion Personal Demanda'],
            [58,'Notificacion Personal Hipotecario'],
            [59,'Notificacion Personal Mandamiento'],
            [60,'Notificacion Personal Martillero'],
            [61,'Notificacion Personal Oficina'],
        ];

        $aranceles = array_map(function($arancel) {
           return [
               'id' => $arancel[0],
               'name' => $arancel[1],
           ];
        }, $aranceles);

        \DB::table('tipo_arancel')->insert($aranceles);
    }
}
