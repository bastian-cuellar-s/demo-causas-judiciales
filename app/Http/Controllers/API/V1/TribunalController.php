<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Tribunal;
use Illuminate\Http\Request;

class TribunalController extends BaseController
{

        protected $tribunal = '';

        public function __construct(Tribunal $tribunal)
        {
            $this->middleware('auth:api');
            $this->tribunal = $tribunal;
        }
        //Metodos necesarios para los resources de TRIBUNAL necesarios en la creación de DELIGENCIAS

        public function index()
        {
         
         $tribunales = Tribunal::get();
         return $this->sendResponse($tribunales, 'Lista Tribunales');
        }
    
        public function store(Request $request)
        {
            $tribunal = $this->tribunal->create([
                'name'     => $request->get('name'),
            ]);
            
            return $this->sendResponse($tribunal, 'Tribunal Creado!');
            
        }
    
        public function update(Request $request, $id){
        
            $tribunal = $this->tribunal->findOrFail($id);
    
            $tribunal->update($request->all());
    
            return $this->sendResponse($tribunal, 'Tribunal Actualizado!');
        }
     
        public function destroy($id){
            
            $this->authorize('isAdmin');
    
            $tribunal = $this->tribunal->findOrFail($id);
    
            $tribunal->delete();
    
            return $this->sendResponse($tribunal, 'Tribunal Borrado!');
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
