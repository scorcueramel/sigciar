<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServicioInscripcion extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'servicio_id',
        'user_id',
        'estado',
        'usuario_creador',
        'usuario_editor',
        'ip_usuario',
    ];
}
