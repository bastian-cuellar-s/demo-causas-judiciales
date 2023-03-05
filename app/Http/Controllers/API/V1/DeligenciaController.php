<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Deligencia;
use App\Models\Persona;
use App\Http\Requests\Deligencia\DeligenciaRequest;
use Illuminate\Support\Facades\DB;
use App\Exports\DeligenciasExport;



class DeligenciaController extends BaseController
{
    protected $deligencia = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Deligencia $deligencia)
    {
        $this->middleware('auth:api');
        $this->deligencia = $deligencia;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $deligencias = $this->deligencia->latest()->paginate(10);

        return $this->sendResponse($deligencias, 'Lista Deligencias');
    }

    public function searchDeligencia(Request $request)
    {
        $search = $request->searchQuery;

        $sort_direction = request('sort_direction','desc');

        if(!in_array($sort_direction,['asc','desc'])){
            $sort_direction = 'desc';
        }

        $sort_field = request('sort_field','updated_at');

        if(!in_array($sort_field,['rol','tribunal', 'materia',  'caratulado',
        'obs','created_at','updated_at'])){
            $sort_field = 'updated_at';
        }

        $paginate = request('paginate',15);

        $query = Deligencia::select('*')
        ->with('cliente.grupoArancel.arancel','abogado.grupoArancel.arancel','demandados','gestion.recibo','gestion.fechas');

        if($search){
            $query->where(function ($q) use ($search) {
                $q->where('rol', 'LIKE', '%'.$search.'%');
                $q->orWhere('tribunal', 'LIKE', '%'.$search.'%');
                $q->orWhere('materia', 'LIKE', '%'.$search.'%');
                $q->orWhere('caratulado', 'LIKE', '%'.$search.'%');
                $q->orWhere('obs', 'LIKE', '%'.$search.'%');                             
                $q->orWhere('created_at', 'LIKE', '%'.$search.'%');                             
                $q->orWhere('updated_at', 'LIKE', '%'.$search.'%');                             
                });
        }

        $deligencias = $query->orderBy($sort_field,$sort_direction)
        ->paginate($paginate);

        return $this->sendResponse($deligencias, 'Search Deligencias list');
    }

    public function allDeligencia()
    {
        $all = Deligencia::pluck('id');
        return $this->sendResponse($all, 'Todos');
    } 

    public function export($dataExport)
    {
        $DeligenciasArray = explode(',',$dataExport);
        return (new DeligenciasExport($DeligenciasArray))->download('deligencias.xlsx');
    }

    public function getDeligenciaCliente(Request $request)
    {
        
        function DateToString($mydate){
            
            if($mydate){
                $parseDate = date('Y/m/d', strtotime($mydate));
                return $parseDate;
            }
        }

        $personas_id = $request->personas_id;

        /*if(personas_id){
            foreach ($personas_id as $persona) {

            }


        }

        $si_funcion_persona = DB::table('personas')
            ->select(['id','funcion'])
            ->where('id','=',$persona_id)
            ->get();*/
        
        //if($si_funcion_persona){

            //$funcion_persona = $si_funcion_persona[0]->funcion . '_id';

            $query = Deligencia::select('*')
            ->with('cliente','abogado')
            ->find($personas_id)->cliente;
            //->where($funcion_persona,'=',$persona_id);

            if($request->input('dates')){
                $f_inicio       = DateToString($request->input('dates.start'));
                $f_fin          = DateToString($request->input('dates.end'));
                $query->whereBetween('f_resolucion', [$f_inicio, $f_fin]);
            }

            $deligencias = $query->orderBy('id', 'DESC')
                                ->paginate(15);

        //}

        return $this->sendResponse($deligencias, 'Deligencia de la persona');
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\Products\ProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DeligenciaRequest $request)
    {
        
        function DateToString($mydate){
            
            if($mydate){
                $parseDate = date('Y/m/d', strtotime($mydate));
                return $parseDate;
            }
        }  
        
        
        
        $deligencia = $this->deligencia->create([
            'cliente_id'        => $request->get('cliente_id'), 
            'abogado_id'        => $request->get('abogado_id'), 
            'demandado_id'        => $request->get('demandado_id'), 
            'rol'               => $request->get('rol'),
            'tribunal'          => $request->get('tribunal'),
            'materia'           => $request->get('materia'),
            'caratulado'        => $request->get('caratulado'),
            'obs'               => $request->get('obs'),
            //'encargo'           => $request->get('encargo'),
            //'cuaderno'          => $request->get('cuaderno'),
            //'estampe'           => $request->get('estampe'),
            //'correo'            => $request->get('correo'),
            //'cobrado'           => $request->get('cobrado'),
            //'pagado'            => $request->get('pagado'),
            //'f_estampado'       => DateToString($request->get('f_estampado')), 
            //'f_resolucion'      => DateToString($request->get('f_resolucion')), 
            //'resultado'         => $request->get('resultado'), 
             
        ]);
            
        $demandados_ids = [];

        if($request->get('demandados')){

            foreach ($request->get('demandados') as $demandado) {
                $demandados_ids[] = $demandado['id'];
            }

        }
        $deligencia->demandados()->sync($demandados_ids);
            
        return $this->sendResponse($deligencia, 'Deligencia creada!');
        
    }
   

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $deligencia = $this->deligencia->with(['category', 'tags'])->findOrFail($id);

        return $this->sendResponse($deligencia, 'Deligencia detalles');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(DeligenciaRequest $request, $id)
    {
        $deligencia = $this->deligencia->findOrFail($id);

        $deligencia->update($request->all());

        if($request->get('demandados')){
            $demandados_ids = [];

            foreach ($request->get('demandados') as $demandado) {
                $demandados_ids[] = $demandado['id'];
            }

            $deligencia->demandados()->sync($demandados_ids);
        }

        return $this->sendResponse($deligencia, 'La información fue actualizada!');
    }


    /*public function updateCorreo($id)
    {
        $deligencia = $this->deligencia->findOrFail($id);

        if($deligencia) {
            $deligencia->correo = TRUE;
            $deligencia->save();
        }

        return $this->sendResponse($deligencia, 'La información fue actualizada!');
    }

    public function updateEstampe($id)
    {
        $deligencia = $this->deligencia->findOrFail($id);

        if($deligencia) {
            $deligencia->estampe = TRUE;
            $deligencia->save();
        }

        return $this->sendResponse($deligencia, 'La información fue actualizada!');
    }

    public function updateCobrado($id)
    {
        $deligencia = $this->deligencia->findOrFail($id);

        if($deligencia) {
            $deligencia->cobrado = TRUE;
            $deligencia->save();
        }

        return $this->sendResponse($deligencia, 'La información fue actualizada!');
    }

    public function updatePagado($id)
    {
        $deligencia = $this->deligencia->findOrFail($id);

        if($deligencia) {
            $deligencia->cobrado = TRUE;
            $deligencia->pagado = TRUE;
            $deligencia->save();
        }

        return $this->sendResponse($deligencia, 'La información fue actualizada!');
    }

    public function updateCorreoF($id)
    {
        $deligencia = $this->deligencia->findOrFail($id);

        if($deligencia) {
            $deligencia->correo = FALSE;
            $deligencia->save();
        }

        return $this->sendResponse($deligencia, 'La información fue actualizada!');
    }

    public function updateEstampeF($id)
    {
        $deligencia = $this->deligencia->findOrFail($id);

        if($deligencia) {
            $deligencia->estampe = FALSE;
            $deligencia->save();
        }

        return $this->sendResponse($deligencia, 'La información fue actualizada!');
    }

    public function updateCobradoF($id)
    {
        $deligencia = $this->deligencia->findOrFail($id);

        if($deligencia) {
            $deligencia->cobrado = FALSE;
            $deligencia->pagado = FALSE;
            $deligencia->save();
        }

        return $this->sendResponse($deligencia, 'La información fue actualizada!');
    }

    public function updatePagadoF($id)
    {
        $deligencia = $this->deligencia->findOrFail($id);

        if($deligencia) {
            $deligencia->pagado = FALSE;
            $deligencia->save();
        }

        return $this->sendResponse($deligencia, 'La información fue actualizada!');
    }*/


    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $this->authorize('isAdmin');

        $deligencia = $this->deligencia->findOrFail($id);

        $deligencia->delete();

        return $this->sendResponse($deligencia, 'Deligencia fue Eliminada!');
    }

    public function destroyAll($deligencias){
        
        $this->authorize('isAdmin');

        $personasArray = explode(',',$deligencias);
        Deligencia::whereKey($personasArray)->delete();

        return $this->sendResponse($deligencias, 'EstasPersonas Fueron Borradas');
    }
}
