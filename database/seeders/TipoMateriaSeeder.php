<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TipoMateriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $materias = [

            [1,'Pagaré, acción cambiaria ordinaria'],
            [2,'Desposeimiento, acción ordinaria de'],
            [3,'Hipotecaria, acción'],
            [4,'Revocatorias, acción pauliana'],
            [5,'Pesos, cobro de'],
            [6,'Contrato, cumplimiento de'],
            [7,'Perjuicios, indemnización de'],
            [8,'Contrato, nulidad de'],
            [9,'Expropiación, nulidad de'],
            [10,'Herencia, petición de'],
            [11,'Cheque, acción ordinaria de cobro'],
            [12,'Letra, acción cambiaria ordinaria'],
            [13,'Indemnización ley de Propiedad Intelectual'],
            [14,'Acciones Revocatorias Concursales'],
            [15,'Otros Sumarios'],
            [16,'Pesos, cobro según art.680 Nº7 CPC'],
            [17,'Precario, inc. 2º art. 2.195 C.C'],
            [18,'Pesca y acuicultura, infracciones a la Ley de'],
            [19,'Arrendamiento, cobro renta bs.raíces urbanos'],
            [20,'Arrendamiento, cobro servicios según D.L.964 y Ley 18.101'],
            [21,'Arrendamiento de bienes muebles, CPC'],
            [22,'Arrendamiento,restitución por expiración tiempo estipulado'],
            [23,'Arrendamiento, predios rústicos'],
            [24,'Arrendamiento, desahucio contrato bienes raices urbanos'],
            [25,'Arrendamiento, indemnización de perjuicios'],
            [26,'Autor, cobro Pequeño Derecho de'],
            [27,'Comodato'],
            [28,'Comodato precario'],
            [29,'Demarcación, procedimiento de'],
            [30,'Honorarios, cobro de (en juicio)'],
            [31,'Indemnización perjuicios art.169 Ley Tránsito'],
            [32,'Indemnización perjuicios art.9 Ley 18.287'],
            [33,'Arrendador,restitución por extinción derecho'],
            [34,'Arrendam.terminación inmediata por no pago rentas o reconven'],
            [35,'Pagaré, notificación de protesto'],
            [36,'Reconocimiento de firma, citación'],
            [37,'Reconocimiento firma,citación y confesión de deuda'],
            [38,'Factura, Notificación de'],
            [39,'Factura, Cobro De'],
            [40,'Ejecutivo, según Ley CORVI'],
            [41,'Hipotecaria, Acción Según Ley De Bancos'],
            [42,'Cheque, Cobro De'],
            [43,'Letra De Cambio, Cobro De'],
            [44,'Pagaré, Cobro De'],
            [45,'Mutuo, cobro ejecutivo de'],
            [46,'Bienes raíces, autorización arrendar'],
            [47,'Bienes raíces, autorización enajenar'],
            [48,'Bienes raíces, autorización gravar'],
            [49,'Bienes raíces, reclamo negativa del Conservador'],
            [50,'Cesión de derechos, autorización para'],
            [51,'Crédito, extravío de título'],
            [52,'Curador, nombramiento de'],
            [53,'Muerte Presunta'],
            [54,'Nombre, autorización cambio de'],
            [55,'Perpetua memoria, información'],
            [56,'Vehículos motorizados, inscripciones en Registro'],
            [57,'Medida prejudicial precautoria'],
            [58,'Medida prejudicial preparatoria'],
            [59,'Medida prejudicial probatoria'],
            [60,'Otras medidas prejudiciales'],
            [61,'Cuentas, rendición de, art. 693 C.P.C.'],
            [62,'Árbitro y derivados, designación de'],
            [63,'Restitución, querella de'],
            [64,'Obra nueva, denuncia de'],
            [65,'Obra ruinosa, denuncia de'],
            [66,'Otros Interdictos Posesorios'],

        ];

        $materias = array_map(function($materia) {
            return [
                'id' => $materia[0],
                'name' => $materia[1],
            ];
         }, $materias);

         \DB::table('materias')->insert($materias);
    }
}
