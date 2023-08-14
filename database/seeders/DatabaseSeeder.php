<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
         $this->call(UsersSeeder::class);
    //    \App\Models\Persona::factory(19)->create();
     //   \App\Models\Proveedor::factory(19)->create();
      //  \App\Models\Categoria::factory(5)->create();
      //  \App\Models\Articulo::factory(10)->create();



    }
}
