<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\TipoCuaderno;
use Illuminate\Http\Request;

class TipoCuadernoController extends BaseController
{

    protected $tipoCuaderno = '';
    
    
    public function __construct(TipoCuaderno $tipoCuaderno)
    {
        $this->middleware('auth:api');
        $this->tipoCuaderno = $tipoCuaderno;
    }

    public function index()
    {
        $tipoCuadernos = $this->tipoCuaderno->latest()->paginate(10);

        return $this->sendResponse($tipoCuadernos, 'Lista Tipos de Cuaderno');
    }

    //Metodos para tener la lista nombres *TIPO_ARANCELES necesarios en la creación de ARANCELES

    public function get()
    {
        $tipoCuaderno = TipoCuaderno::get();

        return $this->sendResponse($tipoCuaderno, 'Tipos de Cuadernos');
    }

    public function store(Request $request)
    {
        $tipoCuaderno = $this->tipoCuaderno->create([
            'name'     => $request->get('name'),
        ]);
        
        return $this->sendResponse($tipoCuaderno, 'Tipo de Cuaderno Creado!');
        
    }

    public function update(Request $request, $id){
    
        $tipoCuaderno = $this->tipoCuaderno->findOrFail($id);

        $tipoCuaderno->update($request->all());

        return $this->sendResponse($tipoCuaderno, 'Tipo de Cuaderno Actualizado!');
    }
 
    public function destroy($id){
        
        $this->authorize('isAdmin');

        $tipoCuaderno = $this->tipoCuaderno->findOrFail($id);

        $tipoCuaderno->delete();

        return $this->sendResponse($tipoCuaderno, 'Tipo de Cuaderno Borrado!');
    }
   
}
