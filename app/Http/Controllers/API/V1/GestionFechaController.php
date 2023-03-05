<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GestionFechas;

class GestionFechaController extends BaseController
{
       
    protected $gestionfechas = '';

    public function __construct(GestionFechas $gestionfechas)
    {
        $this->middleware('auth:api');
        $this->gestionfechas = $gestionfechas;
    }
    
    //Metodos necesarios para los resources de MATERIA necesarios en la creación de DELIGENCIAS

   
       public function store(Request $request)
       {
            function DateToString($mydate){
                
                if($mydate){
                    $parseDate = date('Y/m/d', strtotime($mydate));
                    return $parseDate;
                }
            }

            $fecha = $request[0];

            $gestionfechas = $this->gestionfechas->create([
                'name'           => $fecha['name'],
                'fecha'          => DateToString($fecha['fecha']),
                'gestion_id'     => $fecha['gestion_id'],
            ]);
           
           return $this->sendResponse($gestionfechas, 'Fecha Creada!');
           
       }
   
       public function update(Request $request, $id){
       
           $gestionfechas = $this->gestionfechas->findOrFail($id);
   
           $gestionfechas->update($request->all());
   
           return $this->sendResponse($gestionfechas, 'Fecha Actualizado!');
       }
    
       public function destroy($id){
           
           $this->authorize('isAdmin');
   
           $gestionfechas = $this->gestionfechas->findOrFail($id);
   
           $gestionfechas->delete();
   
           return $this->sendResponse($gestionfechas, 'Fecha Borrada!');
       }
    

    public function create()
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }
}
