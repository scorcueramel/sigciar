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
        Schema::create('servicio_informes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('servicioinscripcion_id')->constrained('servicio_inscripcions');
            $table->string('detalle',300);
            $table->string('adjuntto',300);
            $table->string('estado',1);
            $table->string('usuario_creador',50)->nullable(true);
            $table->string('usuario_editor',50)->nullable(true);;
            $table->string('ip_usuario',20);
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
        Schema::dropIfExists('servicio_informes');
    }
};
