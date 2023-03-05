<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Recibo;
use App\Models\ExtrasRecibo;
use Illuminate\Http\Request;

class ReciboController extends BaseController
{
    protected $recibo = '';
    
    
    public function __construct(Recibo $recibo)
    {
        $this->middleware('auth:api');
        $this->recibo = $recibo;
    }

    public function index(Request $request)
    {
        
        $recibos = $this->recibo->get();

        return $this->sendResponse($recibos, 'Recibos lista');
    }


    public function store(Request $request)
    {

        function DateToString($mydate){
            
            if($mydate){
                $parseDate = date('Y/m/d', strtotime($mydate));
                return $parseDate;
            }
        }  

        $recibo = $this->recibo->create([
            'f_recibo'          => DateToString($request->get('f_recibo')),
            'total'             => $request->get('total'),
            'boleta'             => $request->get('boleta'),
            'obs'               => $request->get('obs'),
            'arancel_id'        => $request->get('arancel_id'),   
            'gestion_id'        => $request->get('gestion_id'),
            'persona_id'        => $request->get('persona_id'),
        ]);

        if($request->get('extras')){
            foreach ($request->get('extras') as $extra) {
                    
                    $newextra = ExtrasRecibo::create([
                        'name' => $extra['name'],
                        'valor' => $extra['valor'],
                        'recibo_id' => $recibo->id,
                    ]);           
            }
        }
        
        return $this->sendResponse($recibo, 'Recibo Creado!');
    }


    public function update(Request $request, $id)
    {
        $recibo = $this->recibo->findOrFail($id);

        $recibo->update($request->all());

        return $this->sendResponse($recibo, 'Recibo Actualizado!');
    }

    public function destroy(Recibo $recibo)
    {
        $this->authorize('isAdmin');

        $recibo = $this->recibo->findOrFail($id);

        $recibo->delete();

        return $this->sendResponse($recibo, 'Recibo Borrado!');
    }
}
