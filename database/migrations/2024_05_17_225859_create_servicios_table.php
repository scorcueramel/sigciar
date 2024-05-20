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
        Schema::create('servicios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tiposervicio_id')->constrained('tipo_servicios');
            $table->foreignId('sede_id')->constrained('sedes');
            $table->foreignId('lugar_id')->constrained('lugars');
            $table->string('capacidad');
            $table->dateTime('inicio');
            $table->dateTime('fin');
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
        Schema::dropIfExists('servicios');
    }
};
