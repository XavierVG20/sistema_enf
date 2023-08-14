<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleMedicosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_medicos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idinforme_medico')->unsigned();
            $table->foreign('idinforme_medico')->references('id')->on('informe_medicos')->onDelete('cascade');
            $table->integer('idinsumo')->unsigned();
            $table->foreign('idinsumo')->references('id')->on('insumos');
            $table->integer('cantidad');
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
        Schema::dropIfExists('detalle_medicos');
    }
}
