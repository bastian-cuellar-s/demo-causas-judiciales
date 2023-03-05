<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExtrasRecibo extends Model
{
    use HasFactory;

    protected $table = 'extras_recibo';

    protected $fillable = [

        'name',
        'valor',
        'recibo_id',
    
    ];
}
