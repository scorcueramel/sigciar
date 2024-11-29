<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailConfirmacion extends Model
{
  use HasFactory;

  protected $fillable = [
    'correo_miembro',
    'nombre_miembro',
    'estado_pago',
    'nombre_programa_actividad',
    'registro_id',
    'sede',
    'lugar',
    'fechas_definidas',
    'hora_inicio',
    'hora_fin',
    'fecha_pago',
    'numero_tarjeta',
    'brand_tarjeta',
    'importe_pagado',
    'correo_encargado',
    'nombre_encargado',
    'nombre_programa',
    'codigo'
  ];

  protected $hidden = [
    'created_at',
    'updated_at',
  ];
}
