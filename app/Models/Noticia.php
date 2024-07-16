<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Noticia extends Model
{
    use HasFactory, SoftDeletes, HasSlug;

    protected $fillable = [
        'titulo',
        'extracto',
        'cuerpo',
        'estado',
        'imagen_destacada',
        'slug',
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

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('titulo')
            ->saveSlugsTo('slug')
            ->allowDuplicateSlugs();
    }

    public function getRouteKeyName(){
        return 'slug';
    }
}
