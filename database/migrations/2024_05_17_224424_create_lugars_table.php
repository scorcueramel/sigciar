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
        Schema::create('lugars', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion',100);
            $table->string('abreviatura',5);
            $table->float('costohora',8,2);
            $table->string('estado',1);
            $table->string('tipo',1);
            $table->string('usuario_creador',50)->nullable(true);
            $table->string('usuario_editor',50)->nullable(true);;
            $table->string('ip_usuario',20);
            $table->foreignId('sede_id')->constrained('sedes');
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
        Schema::dropIfExists('lugars');
    }
};
