<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\TipoArancel;
use Illuminate\Http\Request;

class TipoArancelController extends BaseController
{

    protected $tipoArancel = '';
    
    
    public function __construct(TipoArancel $tipoArancel)
    {
        $this->middleware('auth:api');
        $this->tipoArancel = $tipoArancel;
    }

    public function index()
    {
        $tipoAranceles = $this->tipoArancel->latest()->get();

        return $this->sendResponse($tipoAranceles, 'Lista Tipos de Aranceles');
    }

    //Metodos para tener la lista nombres *TIPO_ARANCELES necesarios en la creación de ARANCELES

    public function get()
    {
        $tipoArancel = TipoArancel::get();

        return $this->sendResponse($tipoArancel, 'Tipos de aranceles');
    }

    public function store(Request $request)
    {
        $tipoArancel = $this->tipoArancel->create([
            'name'     => $request->get('name'),
        ]);
        
        return $this->sendResponse($tipoArancel, 'Tipo de Arancel Creado!');
        
    }

    public function update(Request $request, $id){
    
        $tipoArancel = $this->tipoArancel->findOrFail($id);

        $tipoArancel->update($request->all());

        return $this->sendResponse($tipoArancel, 'Tipo de Arancel Actualizado!');
    }
 
    public function destroy($id){
        
        $this->authorize('isAdmin');

        $tipoArancel = $this->tipoArancel->findOrFail($id);

        $tipoArancel->delete();

        return $this->sendResponse($tipoArancel, 'Tipo de Arancel Borrado!');
    }
   
}
