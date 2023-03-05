<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\Personas\PersonaRequest;
use App\Models\Persona;
use App\Models\FuncionPersona;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;


class PersonaController extends BaseController
{
    protected $persona = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Persona $persona)
    {
        $this->middleware('auth:api');
        $this->persona = $persona;
    }
    
    public function index(Request $request)
    {
        $personas = $this->persona->latest()->with('abogado')->paginate(10);

        return $this->sendResponse($personas, 'Personas list');
    }

    public function searchPersona(Request $request)
    {
        $search = $request->searchQuery;

        $fun = $request->fun;

        $sort_direction = request('sort_direction','desc');

        if(!in_array($sort_direction,['asc','desc'])){
            $sort_direction = 'desc';
        }

        $sort_field = request('sort_field','updated_at');

        if(!in_array($sort_field,['name','APaterno', 'AMaterno','rut','email','telefono','obs','representante','tipo_persona','funcion','created_at','updated_at'])){
            $sort_field = 'updated_at';
        }

        $paginate = request('paginate',15);

        /*$query = Persona::select('id','name','APaterno', 'AMaterno','rut','email',
        'telefono','obs','representante','tipo_persona','funcion','created_at','updated_at')
        ->with('abogado');*/
        $query = Persona::select('*')
        ->with('domicilio');

        if($fun){
            $query->where('funcion', $fun);
        }

        if($search){
            $query->where(function ($q) use ($search) {
                    $q->where('name', 'LIKE', '%'.$search.'%');
                    $q->orWhere('APaterno', 'LIKE', '%'.$search.'%');
                    $q->orWhere('AMaterno', 'LIKE', '%'.$search.'%');
                    $q->orWhere('rut', 'LIKE', '%'.$search.'%');
                    $q->orWhere('email', 'LIKE', '%'.$search.'%');
                    $q->orWhere('telefono', 'LIKE', '%'.$search.'%');
                    $q->orWhere('obs', 'LIKE', '%'.$search.'%');
                    $q->orWhere('representante', 'LIKE', '%'.$search.'%');
                    $q->orWhere('tipo_persona', 'LIKE', '%'.$search.'%');
                    $q->orWhere('funcion', 'LIKE', '%'.$search.'%');                            
                    $q->orWhere('created_at', 'LIKE', '%'.$search.'%');                            
                    $q->orWhere('updated_at', 'LIKE', '%'.$search.'%');                            
                });
        }

        $personas = $query->orderBy($sort_field, $sort_direction)
        ->paginate($paginate);

        /*if(!$search){
            $personas = $this->persona->latest()->with('abogado')->paginate(10);
        }
        else{
        $personas = DB::table('personas')
                    ->select(['name','APaterno', 'AMaterno','rut','email','telefono','obs','representante','tipo_persona','funcion'])
                    ->where(function ($query) use ($search) {  // <<<
                        $query->where('name', 'LIKE', '%'.$search.'%')
                            ->orWhere('APaterno', 'LIKE', '%'.$search.'%')
                            ->orWhere('AMaterno', 'LIKE', '%'.$search.'%')
                            ->orWhere('rut', 'LIKE', '%'.$search.'%')
                            ->orWhere('email', 'LIKE', '%'.$search.'%')
                            ->orWhere('telefono', 'LIKE', '%'.$search.'%')
                            ->orWhere('obs', 'LIKE', '%'.$search.'%')
                            ->orWhere('representante', 'LIKE', '%'.$search.'%')
                            ->orWhere('tipo_persona', 'LIKE', '%'.$search.'%')
                            ->orWhere('funcion', 'LIKE', '%'.$search.'%');                            
                    })
                    ->orderBy('id', 'DESC')
                    ->paginate(10);
        }*/

        return $this->sendResponse($personas, 'Search Personas list');
    }

    public function allPersona()
    {
        $all = Persona::pluck('id');
        
        return $this->sendResponse($all, 'Todos');
    }

    public function listaClientesAbogadosAll(Request $request)
    {

        $search = $request->searchQuery;

        $query = Persona::select('id','name','rut')
        ->where('funcion', '!=' ,"demandado");
        

        if($search){
            $query->where(function ($q) use ($search) {
                    $q->where('name', 'LIKE', '%'.$search.'%');
                    $q->orWhere('rut', 'LIKE', '%'.$search.'%');                       
                });
        }

        $ClientesAbogados = $query->orderBy('updated_at', 'DESC')
        ->paginate(10);

        return $this->sendResponse($ClientesAbogados, 'Clientes-Abogados lista');
    }

    public function listaAbogados(Request $request)
    {

        $search = $request->searchQuery;

        $query = Persona::select('id','name','rut')
        ->where('funcion',"abogado");

        if($search){
            $query->where(function ($q) use ($search) {
                    $q->where('name', 'LIKE', '%'.$search.'%');
                    $q->orWhere('rut', 'LIKE', '%'.$search.'%');                       
                });
        }

        $abogados = $query->orderBy('updated_at', 'DESC')
        ->paginate(10);

        return $this->sendResponse($abogados, 'Abogados lista');
    }

    public function listaClientes(Request $request)
    {
        $search = $request->searchQuery;

        $query = Persona::select('id','name','rut','representante')
        ->where('funcion',"cliente");

        if($search){
            $query->where(function ($q) use ($search) {
                    $q->where('name', 'LIKE', '%'.$search.'%');
                    $q->orWhere('rut', 'LIKE', '%'.$search.'%');                       
                });
        }

        $clientes = $query->orderBy('updated_at', 'DESC')
        ->paginate(10);

        return $this->sendResponse($clientes, 'Clientes lista');
    }

    public function listaDemandados(Request $request)
    {

        $search = $request->searchQuery;

        $query = Persona::select('id','name','rut')
        ->where('funcion',"demandado");

        if($search){
            $query->where(function ($q) use ($search) {
                    $q->where('name', 'LIKE', '%'.$search.'%');
                    $q->orWhere('rut', 'LIKE', '%'.$search.'%');                       
                });
        }

        $demandados = $query->orderBy('updated_at', 'DESC')
        ->paginate(10);

        return $this->sendResponse($demandados, 'Demandados lista');
    }
    

    public function listaAbogadosCliente(Request $request)
    {
        $cliente_idx = $request->cliente_id;

        $search = $request->searchQuery;

        $query = Persona::join('cliente_abogado', 'personas.id', '=', 'cliente_abogado.abogado_id')
        ->where('cliente_abogado.persona_id', '=', $cliente_idx)
        ->select('id','name','rut')
        ->where('funcion',"abogado");

        if($search){
            $query->where(function ($q) use ($search) {
                    $q->where('name', 'LIKE', '%'.$search.'%');
                    $q->orWhere('rut', 'LIKE', '%'.$search.'%');                       
                });
        }

        $abogados = $query->orderBy('updated_at', 'DESC')
        ->paginate(10);

        /*$abogados = DB::table('personas')
                    ->join('cliente_abogado', 'personas.id', '=', 'cliente_abogado.abogado_id')
                    ->where('cliente_abogado.persona_id', '=', $cliente_idx)
                    ->select('id','name','rut')->where('funcion',"abogado")
                    ->get();*/

        return $this->sendResponse($abogados, 'Abogados lista clientes');
    }

    public function listaPersonasRecibo(Request $request)
    {
        $cliente_idx = $request->cliente_id;
        $abogado_idx = $request->abogado_id;
        $demandado_idx = $request->demandado_id;

        $personas_recibo = DB::table('personas')
        ->whereIn('id', [$cliente_idx, $abogado_idx, $demandado_idx])
        ->get();

        return $this->sendResponse($personas_recibo, 'Info de personas del recibo');
    }
    
    /*public function get($id)
    {
        $persona = Persona::whereId($id)->first();
        return response()->json([
            "persona" => $personas
        ], 200);
        return $this->sendResponse($persona, 'persona');
    }*/
 
    public function show($id)
    {
        $persona = $this->persona->findOrFail($id);

        return $this->sendResponse($persona, 'Persona Details');
    }
    
    public function store(PersonaRequest $request)
    {
        $persona = $this->persona->create([
            'name'          => $request->get('name'),
            'APaterno'      => $request->get('APaterno'),   
            'AMaterno'      => $request->get('AMaterno'), 
            'rut'           => $request->get('rut'), 
            'email'         => $request->get('email'), 
            'telefono'      => $request->get('telefono'), 
            'obs'           => $request->get('obs'), 
            'tipo_persona'  => $request->get('tipo_persona'),
            'funcion'       => $request->get('funcion'),
            'representante'  => $request->get('representante'),
            'g_arancel_id'  => $request->get('g_arancel_id'),
        ]);
        
        /*$funciones_ids = [];

        foreach ($request->get('funciones') as $funcion) {
            $funciones_ids[] = $funcion['id'];
        }
        $persona->funcion_personas()->sync($funciones_ids);

        return $this->sendResponse($persona, 'Creada satisfactoriamente');*/
        
        /*if($request->get('funcion')=='abogado'){
            return $this->sendResponse($persona, 'Creada satisfactoriamente');
        }else{
            $abogados_ids = [];
            foreach ($request->get('abogado') as $abogado) {
                $abogados_ids[] = $abogado['id'];
            }
            $persona->ClienteAbogado()->sync($abogados_ids);
            return $this->sendResponse($persona, 'Creada satisfactoriamente');
        }*/

        return $this->sendResponse($persona, 'Creada satisfactoriamente');
    }

    
 
    public function update(PersonaRequest $request, $id){
    
        $persona = $this->persona->findOrFail($id);

        $persona->update($request->all());

        /*if($request->get('funcion')=='abogado'){
            return $this->sendResponse($persona, 'Información actualizada');
        }else{
            $abogados_ids = [];
            foreach ($request->get('abogado') as $abogado) {
                $abogados_ids[] = $abogado['id'];
            }
            $persona->ClienteAbogado()->sync($abogados_ids);
            return $this->sendResponse($persona, 'Información actualizada');
        }*/    
        // update pivot table
        /*$tag_ids = [];
        foreach ($request->get('tags') as $tag) {
            $tag_ids[] = $tag['id'];
        }
        $product->tags()->sync($tag_ids);*/

        return $this->sendResponse($persona, 'Información actualizada');
    }
 
    public function destroy($id){
        
        $this->authorize('isAdmin');

        $persona = $this->persona->findOrFail($id);

        $persona->delete();

        return $this->sendResponse($persona, 'Esta Persona fue borrada');
    }

    public function destroyAll($personas){
        
        $this->authorize('isAdmin');

        $personasArray = explode(',',$personas);
        Persona::whereKey($personasArray)->delete();

        return $this->sendResponse($personas, 'EstasPersonas Fueron Borradas');
    }
}
