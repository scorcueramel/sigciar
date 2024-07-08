<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubtipoServicio extends Model
{
//    use HasFactory, SoftDeletes; descomentar al migrar, ya fue agregado a la migracion
    use HasFactory;

    protected $fillable = [
        'titulo',
        'subtitulo',
        'estado',
        'imagen',
        'medicion',
        'tiposervicio_id',
    ];
}
