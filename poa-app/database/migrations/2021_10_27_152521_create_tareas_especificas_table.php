<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTareasEspecificasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tareas_especificas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_tarea');

            $table->unsignedBigInteger('actividad_id');
            $table->string('uuid', 49)->unique();
            $table->foreign('actividad_id')->references('id')->on('actividades');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tareas_especificas');
    }
}
