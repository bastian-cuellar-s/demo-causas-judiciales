<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deligencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'abogado_id',
        'demandado_id',
        'rol',
        'tribunal',    
        'materia',  
        'caratulado',
        'obs', 
     ];

     public function cliente()
    {
        return $this->belongsTo(Persona::class,'cliente_id');
    }

     public function abogado()
    {
        return $this->belongsTo(Persona::class,'abogado_id');
    }

     public function demandado()
    {
        return $this->belongsTo(Persona::class,'demandado_id');
    }

    public function gestion()
    { 
        return $this->hasMany(Gestion::class);
    }

    public function demandados()
    {
        return $this->belongsToMany(Persona::class,
        'diligencia_demandado_pivot','diligencia_id','demandado_id');
    }
     
}
