<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arancel extends Model
{
    use HasFactory;

    protected $table = 'aranceles';


    protected $fillable = [
        'name',
        'valor',
        'g_arancel_id',
     ]; 
}
