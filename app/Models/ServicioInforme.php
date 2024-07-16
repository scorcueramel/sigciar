<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServicioInforme extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'servicioinscripcion_id',
        'detalle',
        'adjuntto',
        'estado',
        'usuario_creador',
        'usuario_editor',
        'ip_usuario',
    ];
}
