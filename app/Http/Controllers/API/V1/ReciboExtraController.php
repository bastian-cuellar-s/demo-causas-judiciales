<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ExtrasRecibo;

class ReciboExtraController extends BaseController
{
       
    protected $reciboExtras = '';

    public function __construct(ExtrasRecibo $reciboExtras)
    {
        $this->middleware('auth:api');
        $this->reciboExtras = $reciboExtras;
    }
    
    //Metodos necesarios para los resources de MATERIA necesarios en la creación de DELIGENCIAS

   
       public function store(Request $request)
       {

            $extra = $request[0];

            $reciboExtras = $this->reciboExtras->create([
                'name'              => $extra['name'],
                'valor'             => $extra['valor'],
                'obs'               => $extra['obs'],
                'recibo_id'         =>  $extra['recibo_id'],
            ]);
           
           return $this->sendResponse($reciboExtras, 'Extra Creada!');
           
       }
   
       public function update(Request $request, $id){
       
           $reciboExtras = $this->reciboExtras->findOrFail($id);
   
           $reciboExtras->update($request->all());
   
           return $this->sendResponse($reciboExtras, 'Extra Actualizado!');
       }
    
       public function destroy($id){
           
           $this->authorize('isAdmin');
   
           $reciboExtras = $this->reciboExtras->findOrFail($id);
   
           $reciboExtras->delete();
   
           return $this->sendResponse($reciboExtras, 'Extra Borrada!');
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
