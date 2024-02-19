<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resultados', function (Blueprint $table) {
            $table->id();
            $table->integer('codigo_resultado');
            $table->string('nombre_resultado');
            $table->unsignedBigInteger('meta_id');
            $table->string('uuid', 49)->unique();
            $table->timestamps();

            $table->foreign('meta_id')->references('id')->on('metas');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resultados');
    }
}
