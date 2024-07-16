<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Servicio extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'tiposervicio_id',
        'sede_id',
        'lugar_id',
        'capacidad',
        'inicio',
        'fin',
        'estado',
        'usuario_creador',
        'usuario_editor',
        'ip_usuario',
        'responsable_id',
        'horas',
        'turno',
        'subtiposervicio_id',
    ];
}
