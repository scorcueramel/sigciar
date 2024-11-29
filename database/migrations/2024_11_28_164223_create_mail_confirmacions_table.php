<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('mail_confirmacions', function (Blueprint $table) {
      $table->id();
      $table->string('correo_miembro')->nullable();
      $table->string('nombre_miembro')->nullable();
      $table->string('estado_pago')->nullable();
      $table->string('nombre_programa_actividad')->nullable();
      $table->string('registro_id')->nullable();
      $table->string('sede')->nullable();
      $table->string('lugar')->nullable();
      $table->text('fechas_definidas')->nullable();
      $table->string('hora_inicio')->nullable();
      $table->string('hora_fin')->nullable();
      $table->string('fecha_pago')->nullable();
      $table->string('numero_tarjeta')->nullable();
      $table->string('brand_tarjeta')->nullable();
      $table->string('importe_pagado')->nullable();
      $table->string('correo_encargado')->nullable();
      $table->string('nombre_encargado')->nullable();
      $table->string('nombre_programa')->nullable();
      $table->string('codigo');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('mail_confirmacions');
  }
};
