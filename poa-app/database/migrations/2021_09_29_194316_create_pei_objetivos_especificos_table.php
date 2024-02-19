<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeiObjetivosEspecificosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pei_objetivos_especificos', function (Blueprint $table) {
            $table->id();
            $table->string('objetivo_institucional');
            $table->integer('ponderacion');
            $table->text('indicador_proceso');
            
            $table->enum('status', [0, 1])->default(1);
            $table->unsignedBigInteger('gerencia_id');
            $table->unsignedBigInteger('mediano_plazo_accion_id');
            $table->string('uuid', 49)->unique();
            $table->timestamps();

            $table->foreign('gerencia_id')->references('id')->on('gerencias');
            $table->foreign('mediano_plazo_accion_id')->references('id')->on('mediano_plazo_acciones');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pei_objetivos_especificos');
    }
}
