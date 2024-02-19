<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedianoPlazoAccionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mediano_plazo_acciones', function (Blueprint $table) {
            $table->id();
            $table->integer('codigo_mediano_plazo');
            $table->string('accion_mediano_plazo');
            $table->unsignedBigInteger('resultado_id');
            $table->string('uuid', 49)->unique();
            $table->timestamps();

            $table->foreign('resultado_id')->references('id')->on('resultados');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mediano_plazo_acciones');
    }
}
