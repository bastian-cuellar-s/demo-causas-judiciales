<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Encargo extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'ext',
        'path',
     ];
}
