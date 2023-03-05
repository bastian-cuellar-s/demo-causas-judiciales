<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Domicilio extends Model
{
    use HasFactory;

    protected $fillable = [
        'direccion',
        'numero', 
        'comuna',  
        'region', 
        'negativa', 
        'obs',
        'persona_id',
     ];

     /*public function persona()
     {
         return $this->belongsTo(Persona::class);
     }*/
}
