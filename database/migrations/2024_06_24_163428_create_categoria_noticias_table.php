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
        Schema::create('categoria_noticias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre',100)->nullable(false);
            $table->string('slug',150)->nullable(false);
            $table->string('estado',5)->nullable(false)->default('A');
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
        Schema::dropIfExists('categoria_noticias');
    }
};
