<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Persona extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'fecharegistro',
        'tipodocumento_id',
        'documento',
        'tipocategoria_id',
        'apepaterno',
        'apematerno',
        'nombres',
        'movil',
        'estado',
        'usuario_creado',
        'usuario_editor',
        'usuario_ip',
        'usuario_id',
    ];
}
