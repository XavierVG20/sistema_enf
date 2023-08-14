<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email',60)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('idrol')->unsigned();
            $table->foreign('idrol')->references('id')->on('roles');
          $table->string('tipo_documento', 20)->nullable();
            $table->string('num_documento', 20)->nullable();
            $table->string('direccion', 70)->nullable();
            $table->string('telefono', 20)->nullable();
            $table->boolean('condicion')->default(1);
            $table->rememberToken();
            $table->timestamps();
        });
      

/*
        DB::table('users'->insert(array(
      
            'name'=>'Kevin Javier',
            'email'=>'kjaviervelasque16@gmail.com',
            'password'=>'$2y$12$fQVExSFUFZCNs.9xClllau9VAWQGMJZq7KNTQ14DgpO2djOIiEeVi',
            'idro'=>'1'
        )));
        */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    
    {
        Schema::dropIfExists('users');
    }
}
