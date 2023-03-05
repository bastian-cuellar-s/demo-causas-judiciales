<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Arancel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Imports\ArancelImport;
use Storage;

class ArancelController extends BaseController
{
    protected $arancel = '';
    
    
    public function __construct(Arancel $arancel)
    {
        $this->middleware('auth:api');
        $this->arancel = $arancel;
    }

    public function index(Request $request)
    {

        $aranceles = Arancel::where('g_arancel_id', $request->g_arancel_id)->paginate(10);

        return $this->sendResponse($aranceles, 'Lista Aranceles');
    }

    public function searchArancel(Request $request)
    {
        $search         = $request->searchQuery;
        $g_arancel_id     = $request->p_id;

        $sort_direction = request('sort_direction','desc');

        if(!in_array($sort_direction,['asc','desc'])){
            $sort_direction = 'desc';
        }

        $sort_field = request('sort_field','updated_at');

        if(!in_array($sort_field,['name','valor','created_at','updated_at'])){
            $sort_field = 'updated_at';
        }

        $paginate = request('paginate',15);

        $query = Arancel::select('id','name','valor','created_at','updated_at')
                ->where('g_arancel_id','=',$g_arancel_id);

        if($search){
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', '%'.$search.'%');
                $q->orWhere('valor', 'LIKE', '%'.$search.'%');
                $q->orWhere('created_at', 'LIKE', '%'.$search.'%');
                $q->orWhere('updated_at', 'LIKE', '%'.$search.'%');
        });
        }

        $aranceles = $query->orderBy($sort_field, $sort_direction)
                            ->paginate($paginate);

        return $this->sendResponse($aranceles, 'Search Arancel list');
    }


    public function store(Request $request)
    {
        $arancel = $this->arancel->create([
            'name'          => $request->get('name'),
            'valor'         => $request->get('valor'),   
            'g_arancel_id'    => $request->get('g_arancel_id'),
        ]);
        
        return $this->sendResponse($arancel, 'Arancel Creado!');
    }

    public function storeExcel(Request $request)
    {
        $file = $request->file('file')->store('import');
        $g_arancel_id = $request->get('g_arancel_id');

        $import = new ArancelImport($g_arancel_id);
        $import->import($file);
        
        $imported = \Excel::toArray($import,$file);

        $aranceles = $imported[0];

        if ($import->failures()->isNotEmpty()) {
            return back()->withFailures($import->failures());
        }

        Storage::delete($file);

        //return back()->withStatus('Import in queue, we will send notification after import finished.');
        return $this->sendResponse($aranceles, 'Import Arancel list');
    }


    public function update(Request $request, $id)
    {
        $arancel = $this->arancel->findOrFail($id);

        $arancel->update($request->all());

        return $this->sendResponse($arancel, 'Arancel Actualizado!');
    }

    public function destroy($id)
    {
        $this->authorize('isAdmin');

        $arancel = $this->arancel->findOrFail($id);

        $arancel->delete();

        return $this->sendResponse($arancel, 'Arancel Borrado!');
    }

}
