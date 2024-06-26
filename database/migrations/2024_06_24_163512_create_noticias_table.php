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
        Schema::create('noticias', function (Blueprint $table) {
            $table->id();
            $table->string('titutlo',120)->nullable(false);
            $table->string('extracto',200)->nullable(false);
            $table->string('cuerpo',900)->nullable(false);
            $table->string('estado',5)->nullable(false)->default('A');
            $table->string('imagen_destacada',50)->nullable(false);
            $table->string('imagen_cuerpo',50)->nullable(true);
            $table->foreignId('categoria_id')->constrained('categoria_noticias');
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
        Schema::dropIfExists('noticias');
    }
};
