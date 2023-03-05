<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Domicilio;
use App\Models\Region;
use App\Models\Comuna;
use Illuminate\Http\Request;
use App\Http\Requests\Domicilio\DomicilioRequest;
use Illuminate\Support\Facades\DB;


class DomicilioController extends BaseController
{
    protected $domicilio = '';
    protected $region = '';
    protected $comuna = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Domicilio $domicilio)
    {
        $this->middleware('auth:api');
        $this->domicilio = $domicilio;
    }
    
    public function index(Request $request)
    {
        $domicilios = Domicilio::where('persona_id', $request->persona_id)->paginate(10);

        return $this->sendResponse($domicilios, 'Lista domicilios');
    }

    public function searchDomicilio(Request $request)
    {
        $search         = $request->searchQuery;
        $persona_id     = $request->p_id;

        $sort_direction = request('sort_direction','desc');

        if(!in_array($sort_direction,['asc','desc'])){
            $sort_direction = 'desc';
        }

        $sort_field = request('sort_field','updated_at');

        if(!in_array($sort_field,['id','direccion','numero','comuna','region','negativa','obs','created_at','updated_at'])){
            $sort_field = 'updated_at';
        }

        $paginate = request('paginate',15);

        $query = Domicilio::select('*')
                ->where('persona_id','=',$persona_id);

        if($search){
            $query->where(function ($q) use ($search) {
                $q->where('direccion', 'LIKE', '%'.$search.'%');
                $q->orWhere('numero', 'LIKE', '%'.$search.'%');
                $q->orWhere('comuna', 'LIKE', '%'.$search.'%');
                $q->orWhere('complemento', 'LIKE', '%'.$search.'%');
                $q->orWhere('region', 'LIKE', '%'.$search.'%');
                $q->orWhere('obs', 'LIKE', '%'.$search.'%');                            
                $q->orWhere('created_at', 'LIKE', '%'.$search.'%');                            
                $q->orWhere('updated_at', 'LIKE', '%'.$search.'%');                            
        });
        }
    
        $domicilios = $query->orderBy($sort_field, $sort_direction)
                            ->paginate($paginate);
                                
        return $this->sendResponse($domicilios, 'Search Domicilios list');
    }
    
    public function get($id)
    {
        $domicilio = Domicilio::whereId($id)->first();
        return $this->sendResponse($domicilio, 'Domicilio');
    }
    
    public function getRegiones()
    {
        $region = Region::get();
        return $this->sendResponse($region, 'Regiones');
    }
    
    public function getComunas(Request $request)
    {
        $comuna = Comuna::where('region_id', $request->region_id)->get();
        return $this->sendResponse($comuna, 'Comunas');
    }
 
    public function show($id)
    {
        $domicilio = $this->domicilio->findOrFail($id);

        return $this->sendResponse($domicilio, 'Domicilio detalles');
    }
    
    public function store(DomicilioRequest $request)
    {
        $domicilio = $this->domicilio->create([
            'direccion'     => $request->get('direccion'),
            'numero'        => $request->get('numero'),   
            'complemento'   => $request->get('complemento'), 
            'comuna'        => $request->get('comuna'), 
            'region'        => $request->get('region'), 
            'obs'           => $request->get('obs'), 
            'persona_id'    => $request->get('persona_id'),
        ]);
        
        return $this->sendResponse($domicilio, 'Domicilio Creado!');
        
    }

    public function update(DomicilioRequest $request, $id){
    
        $domicilio = $this->domicilio->findOrFail($id);

        $domicilio->update($request->all());

        return $this->sendResponse($domicilio, 'Domicilio Actualizado!');
    }
 
    public function destroy($id){
        
        $this->authorize('isAdmin');

        $domicilio = $this->domicilio->findOrFail($id);

        $domicilio->delete();

        return $this->sendResponse($domicilio, 'Domicilio Borrado!');
    }
}
