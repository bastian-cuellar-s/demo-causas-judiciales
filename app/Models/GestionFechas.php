<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GestionFechas extends Model
{
    use HasFactory;

    protected $table = 'gestion_fechas';

    protected $fillable = [

        'name',
        'fecha',
        'gestion_id',
    ];
}
