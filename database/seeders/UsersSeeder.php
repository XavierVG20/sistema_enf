<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert(array('id'=>'1',
        'name'=>'Administrador',
         'email'=>'admin@admin.com', 
         'password' => Hash::make('admin'),
         'tipo_documento'=>'C.I',
         'num_documento'=>'05467834',
         'direccion' => 'Quito',
         'telefono'=>'05467834',
          'idrol'=>'1'));

        DB::table('users')->insert(array('id'=>'2',
        'name'=>'enfermera',
         'email'=>'enfermera@enfermera.com', 
         'password' => Hash::make('1234'),
         'tipo_documento'=>'C.I',
         'num_documento'=>'05467834',
         'direccion' => 'Quito',
         'telefono'=>'05467834',
          'idrol'=>'2'));

        
    }
}
