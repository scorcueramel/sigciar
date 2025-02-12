<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicio_disponibles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('servicioplantilla_id')->constrained('servicio_plantillas');
            $table->string('dia',20)->nullable(true);
            $table->dateTime('inicio');
            $table->dateTime('fin');
            $table->string('estado',5);
            $table->string('usuario_creador',50)->nullable(true);
            $table->string('usuario_editor',50)->nullable(true);
            $table->string('ip_usuario',20);
            $table->integer('servicioinscripcion_id')->nullable(true);
            $table->softDeletes();
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
        Schema::dropIfExists('servicio_disponibles');
    }
};
