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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->dateTime('fecharegistro');
            $table->foreignId('tipodocumento_id')->constrained('tipo_documentos');
            $table->string('documento');
            $table->foreignId('tipocategoria_id')->constrained('tipo_categorias');
            $table->string('apepaterno',50);
            $table->string('apematerno',50);
            $table->string('nombres',100);
            $table->string('movil',15);
            $table->string('estado',1);
            $table->string('usuario_creado',50);
            $table->string('usuario_editor',50);
            $table->string('usuario_ip',50);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->softDeletes();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
