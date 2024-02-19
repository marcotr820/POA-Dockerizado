<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('bien_servicio');
            $table->date('fecha_requerida');
            $table->integer('presupuesto');
            $table->unsignedBigInteger('partida_id');
            $table->unsignedBigInteger('actividad_id');
            $table->string('uuid', 49)->unique();
            $table->foreign('partida_id')->references('id')->on('partidas');
            $table->foreign('actividad_id')->references('id')->on('actividades');
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
        Schema::dropIfExists('items');
    }
}
