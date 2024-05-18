<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServicioPlantilla extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'servicio_id',
        'inicio',
        'fin',
        'periodicidad_id',
        'usuario_creador',
        'usuario_editor',
        'usuario_ip',
    ];
}
