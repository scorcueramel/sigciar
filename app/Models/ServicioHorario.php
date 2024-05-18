<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServicioHorario extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'servicioplantilla_id',
        'dia',
        'horainicio',
        'horafin',
        'estado',
        'usuario_creador',
        'usuario_editor',
        'usuario_ip',
    ];
}
