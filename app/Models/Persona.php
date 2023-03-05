<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'APaterno', 
        'AMaterno',  
        'rut', 
        'email',
        'telefono',
        'obs',
        'representante',
        'tipo_persona',
        'funcion',
        'g_arancel_id',
     ];

    public function abogado()
    {
        return $this->belongsToMany(Persona::class, 'cliente_abogado','persona_id','abogado_id')
        ->select(['id','name','rut'])
        ->where('funcion',"abogado");

    }

    public function ClienteAbogado()
    {
        return $this->belongsToMany(Persona::class, 'cliente_abogado','persona_id','abogado_id');

    }

    public function domicilio()
    { 
        return $this->hasMany(Domicilio::class);
    }

    public function grupoArancel()
    { 
        return $this->belongsTo(GrupoArancel::class,'g_arancel_id');
    }

    public function funcion_personas()
    {
           
        return $this->belongsToMany(FuncionPersona::class,
        'funcion_personas_personas','persona_id','funcion_personas_id');

    }
     
}
