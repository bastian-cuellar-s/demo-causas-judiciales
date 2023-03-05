<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Encargo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EncargoController extends BaseController
{
    
    protected $encargo = '';

    public function __construct(Encargo $encargo)
    {
        $this->middleware('auth:api');
        $this->encargo = $encargo;
    }
    
    //Metodos necesarios para los resources de ENCARGOS necesarios en la creación de DELIGENCIAS

    public function index()
    {
     
     $encargos = Encargo::get();

     return $this->sendResponse($encargos, 'Lista Encargos');
    }


    public function store(Request $request)
    {

        $fileUpload = new Encargo;
    
            if($request->file()) {
                $file_full_name = $request->file->getClientOriginalName();
                $file_name = pathinfo($file_full_name, PATHINFO_FILENAME);
                $file_ext = pathinfo($file_full_name, PATHINFO_EXTENSION);  
                $file_path = $request->file('file')->storeAs('templates', $file_full_name, 'wordStorage');
    
                $fileUpload->name = $file_name;
                $fileUpload->ext = $file_ext;
                $fileUpload->path = '/storage/' . $file_path;
                $fileUpload->save();
    
                //return response()->json(['success'=>'File uploaded successfully.']);
            }
        
        return $this->sendResponse($fileUpload, 'Encargo Creado!');
        
    }

    public function update(Request $request, $id){
    
        $encargo = $this->encargo->findOrFail($id);

        $encargo->update($request->all());

        return $this->sendResponse($encargo, 'Encargo Actualizado!');
    }
 
    public function destroy($id){
        
        $this->authorize('isAdmin');

        //$encargo = $this->encargo->findOrFail($id);
        $encargo = Encargo::findOrFail($id);

        
        /*if(File::exists(storage_path('templates/'.$encargo->name))){
            File::delete(storage_path('templates/'.$encargo->name));
        }*/

        if(Storage::disk('wordStorage')->exists('templates/'.$encargo->name.'.'.$encargo->ext)){
            Storage::disk('wordStorage')->delete('templates/'.$encargo->name.'.'.$encargo->ext);
        }

        $encargo->delete();

        return $this->sendResponse($encargo, 'Encargo Borrado!');
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
