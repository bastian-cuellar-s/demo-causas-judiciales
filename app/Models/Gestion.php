<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gestion extends Model
{
    use HasFactory;

    protected $table = 'gestiones';

    protected $fillable = [
        'encargo',
        'cuaderno',
        'folio',
        'deuda',
        'estampe',
        'correo',
        'cobrado',
        'pagado',
        'f_estampado',
        'f_notificacion',
        'resultado',
        'deligencia_id',
    ];

    public function fechas()
    { 
        return $this->hasMany(GestionFechas::class);
    }
    
    public function recibo()
    {
        return $this->hasOne(Recibo::class);
    }

    public function deligencia()
    { 
        return $this->belongsTo(Deligencia::class,'deligencia_id');
    }
    
}
