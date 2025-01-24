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
        Schema::create('promesas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->nullable(true);
            $table->string('peso')->nullable(true);
            $table->string('estatura')->nullable(true);
            $table->string('mano')->nullable(true);
            $table->string('academia')->nullable(true);
            $table->string('preparador')->nullable(true);
            $table->string('nutricionista')->nullable(true);
            $table->text('detalle')->nullable(true);
            $table->string('foto')->nullable(true);
            $table->string('edad')->nullable(true);
            $table->string('utr')->nullable(true);
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
        Schema::dropIfExists('promesas');
    }
};
