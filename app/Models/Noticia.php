<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Noticia extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'titulo',
        'extracto',
        'cuerpo',
        'estado',
        'imagen_destacada',
        'categoria_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function setTituloAttribute($value){
        $this->attributes['titulo'] = strtolower($value);
    }
}
