<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recibo extends Model
{
    use HasFactory;

    protected $fillable = [
        
    'total',
    'boleta',
    'obs',
    'arancel_id',
    'gestion_id',
    'persona_id',

    ];

    public function extrasRecibo()
    {
        return $this->hasMany(ExtrasRecibo::class);
    }

    public function arancel()
    {
        return $this->belongsTo(Arancel::class, 'arancel_id');
    }

    
}
