<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvaluacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluaciones', function (Blueprint $table) {
            $table->id();
            $table->integer('resultado_esperado');
            $table->integer('resultado_logrado');
            $table->float('eficacia', 10, 2);
            $table->float('presupuesto', 10, 2);
            $table->float('presupuesto_ejecutado', 10, 2);
            $table->float('ejecucion');
            $table->float('relacion_avance');
            $table->string('trimestre');
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
        Schema::dropIfExists('evaluaciones');
    }
}
