<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrupoArancel extends Model
{
    use HasFactory;

    protected $table = 'grupo_aranceles';


    protected $fillable = [
        'name',
        'obs',
     ]; 

     public function arancel()
    {
        return $this->hasMany(Arancel::class,'g_arancel_id');
    }

}
