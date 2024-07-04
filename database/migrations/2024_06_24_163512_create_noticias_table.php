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
            $table->string('titulo',200)->nullable(false);
            $table->text('extracto')->nullable(false);
            $table->text('cuerpo')->nullable(false);
            $table->string('estado',5)->nullable(false);
            $table->string('imagen_destacada',50)->nullable(false);
            $table->string('slug',400)->nullable(true)->unique();
            $table->foreignId('categoria_id')->constrained('categoria_noticias');
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
        Schema::dropIfExists('noticias');
    }
};
