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
        Schema::create('servicio_horarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('servicioplantilla_id')->constrained('servicio_plantillas');
            $table->string('dia',20);
            $table->time('horainicio');
            $table->time('horafin');
            $table->string('estado',1);
            $table->string('usuario_creador',50);
            $table->string('usuario_editor',50);
            $table->string('usuario_ip',20);
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
        Schema::dropIfExists('servicio_horarios');
    }
};
