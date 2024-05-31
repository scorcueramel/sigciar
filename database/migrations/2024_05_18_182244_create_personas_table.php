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
        Schema::create('personas', function (Blueprint $table) {
            $table->id();
            $table->string('imagen')->nullable(true);
            $table->dateTime('fecharegistro');
            $table->foreignId('tipodocumento_id')->constrained('tipo_documentos');
            $table->string('documento')->unique();
            $table->foreignId('tipocategoria_id')->constrained('tipo_categorias');
            $table->string('apepaterno',50);
            $table->string('apematerno',50);
            $table->string('nombres',100);
            $table->string('movil',15);
            $table->string('directorio',20)->nullable(true);
            $table->string('estado',1);
            $table->string('usuario_creador',50);
            $table->string('usuario_editor',50)->nullable(true);
            $table->string('ip_usuario',50);
            $table->foreignId('usuario_id')->constrained('users');
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
        Schema::dropIfExists('personas');
    }
};
