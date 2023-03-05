<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoCuaderno extends Model
{
    use HasFactory;

    protected $table = 'tipo_cuadernos';


    protected $fillable = [
        'name',
     ];
}
