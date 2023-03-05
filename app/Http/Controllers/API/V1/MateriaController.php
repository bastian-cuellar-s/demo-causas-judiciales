<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Materia;
use Illuminate\Http\Request;

class MateriaController extends BaseController
{
       
    protected $materia = '';

    public function __construct(Materia $materia)
    {
        $this->middleware('auth:api');
        $this->materia = $materia;
    }
    
    //Metodos necesarios para los resources de MATERIA necesarios en la creación de DELIGENCIAS

       public function index()
       {
        
        $materias = Materia::get();

        return $this->sendResponse($materias, 'Lista Materias');
       }

   
       public function store(Request $request)
       {
           $materia = $this->materia->create([
               'name'     => $request->get('name'),
           ]);
           
           return $this->sendResponse($materia, 'Materia Creado!');
           
       }
   
       public function update(Request $request, $id){
       
           $materia = $this->materia->findOrFail($id);
   
           $materia->update($request->all());
   
           return $this->sendResponse($materia, 'Materia Actualizado!');
       }
    
       public function destroy($id){
           
           $this->authorize('isAdmin');
   
           $materia = $this->materia->findOrFail($id);
   
           $materia->delete();
   
           return $this->sendResponse($materia, 'Materia Borrado!');
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
