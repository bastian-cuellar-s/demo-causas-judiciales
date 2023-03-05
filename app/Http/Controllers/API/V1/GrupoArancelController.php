<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\GrupoArancel;
use Illuminate\Http\Request;


class GrupoArancelController extends BaseController
{
    protected $grupoArancel = '';
    
    
    public function __construct(GrupoArancel $grupoArancel)
    {
        $this->middleware('auth:api');
        $this->grupoArancel = $grupoArancel;
    }

    public function index(Request $request)
    {

        $grupoAranceles = GrupoArancel::get();

        return $this->sendResponse($grupoAranceles, 'Lista Aranceles');
    }

    public function searchGrupoArancel(Request $request)
    {
        $search         = $request->searchQuery;

        $sort_direction = request('sort_direction','desc');

        if(!in_array($sort_direction,['asc','desc'])){
            $sort_direction = 'desc';
        }

        $sort_field = request('sort_field','updated_at');

        if(!in_array($sort_field,['name','obs','created_at','updated_at'])){
            $sort_field = 'updated_at';
        }

        $paginate = request('paginate',15);

        $query = GrupoArancel::select('*');

        if($search){
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', '%'.$search.'%');
                $q->orWhere('obs', 'LIKE', '%'.$search.'%');
                $q->orWhere('created_at', 'LIKE', '%'.$search.'%');
                $q->orWhere('updated_at', 'LIKE', '%'.$search.'%');
        });
        }

        $grupoAranceles = $query->orderBy($sort_field, $sort_direction)
                            ->paginate($paginate);

        return $this->sendResponse($grupoAranceles, 'Search GrupoArancel list');
    }


    public function store(Request $request)
    {
        $grupoArancel = $this->grupoArancel->create([
            'name'          => $request->get('name'),
            'obs'         => $request->get('obs'),   
        ]);
        
        return $this->sendResponse($grupoArancel, 'GrupoArancel Creado!');
    }

    public function update(Request $request, $id)
    {
        $grupoArancel = $this->grupoArancel->findOrFail($id);

        $grupoArancel->update($request->all());

        return $this->sendResponse($grupoArancel, 'GrupoArancel Actualizado!');
    }

    public function destroy($id)
    {
        $this->authorize('isAdmin');

        $grupoArancel = $this->grupoArancel->findOrFail($id);

        $grupoArancel->delete();

        return $this->sendResponse($grupoArancel, 'GrupoArancel Borrado!');
    }

}
