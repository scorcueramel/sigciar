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
        Schema::create('servicio_plantillas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('servicio_id')->constrained('servicios');
            $table->dateTime('inicio');
            $table->dateTime('fin');
            $table->foreignId('periodicidad_id')->constrained('periodicidads');
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
        Schema::dropIfExists('servicio_plantillas');
    }
};
