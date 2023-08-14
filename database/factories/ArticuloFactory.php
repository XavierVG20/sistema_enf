<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ArticuloFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'idcategoria' => $this->faker->randomDigitNotNull(),
            'codigo' => $this->faker->ean8(),
            'nombre' => $this->faker->words(3, true),
            'precio_venta' => $this->faker->randomFloat(2),
            'stock' => $this->faker->numberBetween(0, 20),
            'descripcion' => $this->faker->sentence(),
            'condicion' => '1',



            'condicion' => '1',
        ];
    }
}
