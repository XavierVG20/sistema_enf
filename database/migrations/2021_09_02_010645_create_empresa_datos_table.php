<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresaDatosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresa_datos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre_empresa');
            $table->string('email');
            $table->string('direccion');
            $table->string('telefono');
            $table->integer('idmedia')->nullable()->unsigned();
            $table->foreign('idmedia')->nullable()->references('id')->on('media')->onDelete('cascade');;
            
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
        Schema::dropIfExists('empresa_datos');
    }
}
