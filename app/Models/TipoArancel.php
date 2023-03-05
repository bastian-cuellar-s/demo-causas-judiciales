<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoArancel extends Model
{
    use HasFactory;

    protected $table = 'tipo_arancel';


    protected $fillable = [
        'name',
     ];
}
