<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOperacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operaciones', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_operacion');

            $table->unsignedBigInteger('corto_plazo_accion_id');
            $table->string('uuid', 49)->unique();
            $table->foreign('corto_plazo_accion_id')->references('id')->on('corto_plazo_acciones');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('operaciones');
    }
}
