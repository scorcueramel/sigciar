<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LugarCosto extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'descripcion',
        'abreviatura',
        'costohora',
        'estado',
        'tipo',
        'lugars_id',
        'tiposervicios_id',
        'usuario_creador',
        'usuario_editor',
        'ip_usuario',
        'sede_id',
    ];
}
