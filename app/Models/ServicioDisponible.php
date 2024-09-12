<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServicioDisponible extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'servicioplantilla_id',
        'dia',
        'inicio',
        'fin',
        'estado',
        'usuario_creador',
        'usuario_editor',
        'ip_usuario',
    ];
}
