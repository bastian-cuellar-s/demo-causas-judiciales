<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \NumberFormatter;

class WORDEstampadoController extends Controller
{
    public function store(Request $request){
        //dd($request->f_notificacion);
        $template = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('templates/'.$request->encargo.'.docx')); 

        
        $cliente                = $request['deligencia']['cliente'];
        $abogado                = $request['deligencia']['abogado'];
        $demandado              = $request->demandado;
        $demandado_domicilio    = $demandado['domicilio'][0];
        $tribunal               = strtoupper($request->deligencia['tribunal']);
        $rol                    = strtoupper($request->deligencia['rol']);
        $caratulado             = strtoupper($request->deligencia['caratulado']);
        $materia                = strtoupper($request->deligencia['materia']);
        $encargo                = strtoupper($request->encargo);
        $cuaderno               = strtoupper($request->cuaderno);
        $folio                  = strtoupper($request->folio);
        $deuda                  = strtoupper($request->deuda);
        $resultado              = $request->resultado;
        $f_notificacion         = $request->f_notificacion;
        $demandado_rut          = $demandado['rut'];
        $direccion              = ucfirst($demandado_domicilio['direccion']);
        $numero                 = $demandado_domicilio['numero'];
        $comuna                 = ucfirst($demandado_domicilio['comuna']);
        $region                 = ucfirst($demandado_domicilio['region']);
        $complemento = " Departamento ".$demandado_domicilio['complemento'];

        if($request->recibo){
            $total = $request->recibo['total'];
            $template->setValue('total', $total);

        }        
        
        if($cliente['representante']){
            $cliente_nombre_representante = $cliente['representante'];
            $cliente_nombre = $cliente['name'];
            $cliente_nombre_representante = strtoupper($cliente_nombre_representante);
            $cliente_nombre = strtoupper($cliente_nombre);
            $template->setValue('cliente', $cliente_nombre_representante);
            
        }else{
            $cliente_nombre = $cliente['name']." ".$cliente['APaterno']." ".$cliente['AMaterno'];
            strtoupper($cliente_nombre);
        }

        $abogado_nombre    = $abogado['name']." ".$abogado['APaterno'];
        strtoupper($abogado_nombre);

        if($demandado['representante']){
            $demandado_nombre_representante = $demandado['representante'];
            $demandado_nombre = $cliente['name'];
            $demandado_nombre_representante = strtoupper($demandado_nombre_representante);
            $demandado_nombre = strtoupper($demandado_nombre);
            $template->setValue('demandado', $demandado_nombre_representante);

        }else{
            $demandado_nombre = $demandado['name']." ".$demandado['APaterno']." ".$demandado['AMaterno'];
            strtoupper($demandado_nombre);
        }
        //Arrays de días y de meses
        $diassemanaN= array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
        $mesesN=array(1=>"Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

        //Lineas para obtener la fecha de hoy
        
        $diaN = date("w");
        $dia = date("d");
        $mes=date("n");
        $anoN = date("Y");

        $f_hoy_num  = $diassemanaN[$diaN]." ".$dia." de ".$mesesN[$mes]." del ".$anoN;
        $f_hoy_letra= $diassemanaN[$diaN]." ".$dia." de ".$mesesN[$mes]." del año ".$anoN;
        //fin lineas fecha hoy

        //configuración de la fecha de notificacion
        $format_noti = strtotime($f_notificacion);
        $dia_noti = date('d',$format_noti);
        $diaN_noti = date('w',$format_noti);
        $mes_noti = date('n',$format_noti);
        $ano_noti = date('Y',$format_noti);
        $f_notificacion_hora = date('H:i',$format_noti);
        
        $f_notificacion_letra = $diassemanaN[$diaN_noti]." ".$dia_noti." de ".$mesesN[$mes_noti]." del año ".$ano_noti;        
        //fin fecha y hora notificacion

        $template->setValue('rol', $rol);
        $template->setValue('tribunal', $tribunal);
        $template->setValue('encargo', $encargo);
        $template->setValue('materia', $materia);
        $template->setValue('caratulado', $caratulado);
        $template->setValue('cuaderno', $cuaderno);
        $template->setValue('cliente', $cliente_nombre);
        $template->setValue('abogado', $abogado_nombre);
        $template->setValue('demandado', $demandado_nombre);
        $template->setValue('demandado_rut', $demandado_rut);
        $template->setValue('folio', $folio);
        $template->setValue('deuda', $deuda);
        $template->setValue('resultado', $resultado);
        $template->setValue('direccion', $direccion);
        $template->setValue('numero', $numero);
        $template->setValue('comuna', $comuna);
        $template->setValue('region', $region);
        $template->setValue('complemento', $complemento);
        $template->setValue('f_hoy_num', $f_hoy_num);
        $template->setValue('f_notificacion_letra', $f_notificacion_letra);
        $template->setValue('f_notificacion_hora', $f_notificacion_hora);
        

        try {
            $template->saveAS(storage_path($rol . '.docx'));
        } catch (Exception $e) {
            
        }

        return response()->download(storage_path($rol . '.docx'), $rol . '.docx')->deleteFileAfterSend(true);
    }
}
