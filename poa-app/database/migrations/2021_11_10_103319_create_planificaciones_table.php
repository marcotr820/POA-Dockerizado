<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanificacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planificaciones', function (Blueprint $table) {
            $table->id();
            $table->integer('primer_trimestre');
            $table->integer('segundo_trimestre');
            $table->integer('tercer_trimestre');
            $table->integer('cuarto_trimestre');
            $table->unsignedBigInteger('corto_plazo_accion_id');
            $table->string('uuid', 49)->unique();
            $table->foreign('corto_plazo_accion_id')->references('id')->on('corto_plazo_acciones');
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
        Schema::dropIfExists('planificaciones');
    }
}
