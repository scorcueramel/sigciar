<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promesa extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'peso',
        'estatura',
        'mano',
        'academia',
        'preparador',
        'nutricionista',
        'detalle',
        'foto',
        'edad',
        'utr'
    ];
}
