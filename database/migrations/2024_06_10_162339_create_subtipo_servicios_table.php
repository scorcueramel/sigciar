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
        Schema::create('subtipo_servicios', function (Blueprint $table) {
            $table->id();
            $table->string('titulo',100);
            $table->string('subtitulo',100);
            $table->string('estado',1);
            $table->string('imagen',50);
            $table->string('medicion',100);
            $table->foreignId('tiposervicio_id')->constrained('tipo_servicios');
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
        Schema::dropIfExists('subtipo_servicios');
    }
};
