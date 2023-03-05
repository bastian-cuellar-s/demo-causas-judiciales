<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Gestion;
use App\Models\GestionFechas;
use Illuminate\Http\Request;
use App\Exports\ReportExport;
use Illuminate\Support\Facades\DB;

class GestionController extends BaseController
{
    protected $gestion = '';

    public function __construct(Gestion $gestion)
    {
        $this->middleware('auth:api');
        $this->gestion = $gestion;
    }
    
    //Metodos necesarios para los resources de GESTION necesarios en la creación de DELIGENCIAS

       public function index()
       {
        
        $gestiones = Gestion::get();

        return $this->sendResponse($gestiones, 'Lista Gestiones');
       }

       public function searchGestion(Request $request)
        {
        $search = $request->searchQuery;

        $deligencia_id = $request->deligencia_id;
        
        $sort_direction = request('sort_direction','desc');

        if(!in_array($sort_direction,['asc','desc'])){
            $sort_direction = 'desc';
        }

        $sort_field = request('sort_field','updated_at');

        if(!in_array($sort_field,['encargo','cuaderno', 'estampe',  'correo',
        'cobrado','pagado','f_estampado','resultado','created_at','updated_at'])){
            $sort_field = 'updated_at';
        }

        $paginate = request('paginate',15);

        $query = Gestion::select('*')
        ->where('deligencia_id',$deligencia_id)
        ->with(
            'fechas',
            'recibo.extrasRecibo',
            'recibo.arancel',
            'deligencia.cliente.grupoArancel.arancel',
            'deligencia.abogado.grupoArancel.arancel',
            'deligencia.demandados.domicilio'
        );

        if($search){
            $query->where(function ($q) use ($search) {
                $q->where('encargo', 'LIKE', '%'.$search.'%');
                $q->orWhere('cuaderno', 'LIKE', '%'.$search.'%');
                $q->orWhere('folio', 'LIKE', '%'.$search.'%');
                $q->orWhere('deuda', 'LIKE', '%'.$search.'%');
                $q->orWhere('f_estampado', 'LIKE', '%'.$search.'%');
                $q->orWhere('f_notificacion', 'LIKE', '%'.$search.'%');
                $q->orWhere('resultado', 'LIKE', '%'.$search.'%');                             
                $q->orWhere('created_at', 'LIKE', '%'.$search.'%');                             
                $q->orWhere('updated_at', 'LIKE', '%'.$search.'%');                             
                });
        }

        $gestiones = $query->orderBy($sort_field,$sort_direction)
        ->paginate($paginate);

        return $this->sendResponse($gestiones, 'Search Gestiones list');
    }

    public function getGestionClienteAbogado(Request $request)
    {
        
        function DateToString($mydate){
            
            if($mydate){
                $parseDate = date('Y/m/d', strtotime($mydate));
                return $parseDate;
            }
        }

        $cliente_id = $request->cliente_id;
        $abogado_id = $request->abogado_id;

        $query = Gestion::select('*')
        ->with('deligencia.cliente','deligencia.abogado','deligencia.demandado');

        if($cliente_id){
            
            $query->whereHas('deligencia', function ($q) use ($cliente_id) {
                $q->where('cliente_id', $cliente_id);
            });

        }
        if($abogado_id){

            $query->whereHas('deligencia', function ($q) use ($abogado_id) {
                $q->where('abogado_id', $abogado_id);
            });
        }

            if($request->input('dates')){
                $f_inicio       = DateToString($request->input('dates.start'));
                $f_fin          = DateToString($request->input('dates.end'));
                $query->whereBetween('f_resolucion', [$f_inicio, $f_fin]);
            }

            $gestiones = $query->orderBy('id', 'DESC')
                                ->paginate(15);

        //}

        return $this->sendResponse($gestiones, 'Deligencia de la persona');
    }

   
       public function store(Request $request)
       {
            function DateToString($mydate){
                
                if($mydate){
                    $parseDate = date('Y/m/d', strtotime($mydate));
                    return $parseDate;
                }
            }

            function DateToStringHours($mydate){
                
                if($mydate){
                    $parseDate = date('Y/m/d H:i', strtotime($mydate));
                    return $parseDate;
                }
            }

           $gestion = $this->gestion->create([
                'encargo'           => $request->get('encargo'),
                'cuaderno'          => $request->get('cuaderno'),
                'folio'             => $request->get('folio'),
                'deuda'             => $request->get('deuda'),
                'estampe'           => $request->get('estampe'),
                'correo'            => $request->get('correo'),
                'cobrado'           => $request->get('cobrado'),
                'pagado'            => $request->get('pagado'),
                'f_estampado'       => DateToString($request->get('f_estampado')),
                'f_notificacion'    => DateToStringHours($request->get('f_notificacion')),
                'resultado'         => $request->get('resultado'), 
                'deligencia_id'     => $request->get('deligencia_id'), 
           ]);
           
           if($request->get('fechas')){
                foreach ($request->get('fechas') as $fecha) {
                        
                        $NewFecha = GestionFechas::create([
                            'name' => $fecha['name'],
                            'fecha' => DateToString($fecha['fecha']),
                            'gestion_id' => $gestion->id,
                        ]);           
                }
            }
            
            
            //$persona->funcion_personas()->sync($funciones_ids);
           
           return $this->sendResponse($gestion, 'Gestion Creado!');
           
       }
   
       public function update(Request $request, $id){
       
           $gestion = $this->gestion->findOrFail($id);
           $gestion->update($request->all());
   
           return $this->sendResponse($gestion, 'Gestion Actualizado!');
       }
    
       public function destroy($id){
           
           $this->authorize('isAdmin');
   
           $gestion = $this->gestion->findOrFail($id);
   
           $gestion->delete();
   
           return $this->sendResponse($gestion, 'Gestion Borrado!');
       }
       
       public function export($dataExport)
        {
            $GestionesArray = explode(',',$dataExport);
            return (new ReportExport($GestionesArray))->download('Gestiones.xlsx');
        }

        public function allGestion()
        {
            $all = Gestion::pluck('id');
            return $this->sendResponse($all, 'Todos');
        } 

       public function updateCorreo($id)
       {
           $gestion = $this->gestion->findOrFail($id);
   
           if($gestion) {
               $gestion->correo = TRUE;
               $gestion->save();
           }
   
           return $this->sendResponse($gestion, 'La información fue actualizada!');
       }
   
       public function updateEstampe($id)
       {
           $gestion = $this->gestion->findOrFail($id);
   
           if($gestion) {
               $gestion->estampe = TRUE;
               $gestion->save();
           }
   
           return $this->sendResponse($gestion, 'La información fue actualizada!');
       }
   
       public function updateCobrado($id)
       {
           $gestion = $this->gestion->findOrFail($id);
   
           if($gestion) {
               $gestion->cobrado = TRUE;
               $gestion->save();
           }
   
           return $this->sendResponse($gestion, 'La información fue actualizada!');
       }
   
       public function updatePagado($id)
       {
           $gestion = $this->gestion->findOrFail($id);
   
           if($gestion) {
               $gestion->cobrado = TRUE;
               $gestion->pagado = TRUE;
               $gestion->save();
           }
   
           return $this->sendResponse($gestion, 'La información fue actualizada!');
       }
   
       public function updateCorreoF($id)
       {
           $gestion = $this->gestion->findOrFail($id);
   
           if($gestion) {
               $gestion->correo = FALSE;
               $gestion->save();
           }
   
           return $this->sendResponse($gestion, 'La información fue actualizada!');
       }
   
       public function updateEstampeF($id)
       {
           $gestion = $this->gestion->findOrFail($id);
   
           if($gestion) {
               $gestion->estampe = FALSE;
               $gestion->save();
           }
   
           return $this->sendResponse($gestion, 'La información fue actualizada!');
       }
   
       public function updateCobradoF($id)
       {
           $gestion = $this->gestion->findOrFail($id);
   
           if($gestion) {
               $gestion->cobrado = FALSE;
               $gestion->pagado = FALSE;
               $gestion->save();
           }
   
           return $this->sendResponse($gestion, 'La información fue actualizada!');
       }
   
       public function updatePagadoF($id)
       {
           $gestion = $this->gestion->findOrFail($id);
   
           if($gestion) {
               $gestion->pagado = FALSE;
               $gestion->save();
           }
   
           return $this->sendResponse($gestion, 'La información fue actualizada!');
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
