<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServicioPago extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'servicioinscripcion_id',
        'valorpago',
        'fechapago',
        'estadopago',
        'estado',
        'usuario_creador',
        'usuario_editor',
        'ip_usuario',
    ];
}
