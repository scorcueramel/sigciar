<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Persona extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'imagen',
        'fecharegistro',
        'tipodocumento_id',
        'documento',
        'tipocategoria_id',
        'apepaterno',
        'apematerno',
        'nombres',
        'movil',
        'directorio',
        'estado',
        'usuario_creador',
        'usuario_editor',
        'ip_usuario',
        'usuario_id',
    ];
}
