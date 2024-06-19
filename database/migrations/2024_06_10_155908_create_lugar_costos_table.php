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
        Schema::create('lugar_costos', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion',100);
            $table->string('abreviatura',5);
            $table->float('costohora',8,2);
            $table->string('estado',1);
            $table->string('tipo',1);
            $table->foreignId('lugars_id')->constrained('lugars');
            $table->foreignId('tiposervicios_id')->constrained('tipo_servicios');
            $table->string('usuario_creador',50);
            $table->string('usuario_editor',50);
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
        Schema::dropIfExists('lugar_costos');
    }
};
