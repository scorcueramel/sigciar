<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sede extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'descripcion',
        'abreviatura',
        'direccion',
        'imagen',
        'estado',
    ];
    protected $hidden = ['created_at', 'updated_at'];
}
