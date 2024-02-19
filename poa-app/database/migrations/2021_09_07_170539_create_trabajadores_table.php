<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrabajadoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trabajadores', function (Blueprint $table) {
            $table->id();
            $table->integer('documento');
            $table->string('nombre');
            $table->string('cargo');
            //indicamos que los valores que puede tenes el estatus es 0, 1 y por defecto al crear un trabajador el campo sea 0
            $table->enum('poa_status', [0, 1])->default(0);
            $table->enum('poa_evaluacion', [0, 1])->default(0);

            // $table->unsignedBigInteger('usuario_id')->unique();
            $table->unsignedBigInteger('unidad_id');

            $table->string('uuid', 49)->unique();

            // $table->foreign('usuario_id')->references('id')->on('usuarios');
            $table->foreign('unidad_id')->references('id')->on('unidades');

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
        Schema::dropIfExists('trabajadores');
    }
}
