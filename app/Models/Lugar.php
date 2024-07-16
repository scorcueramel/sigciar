<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lugar extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'descripcion',
        'abreviatura',
        'costohora',
        'estado',
        'tipo',
        'usuario_creador',
        'usuario_editor',
        'ip_usuario',
        'serde_id',
    ];
}
