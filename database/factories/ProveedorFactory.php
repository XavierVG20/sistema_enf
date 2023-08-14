<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProveedorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'contacto' => $this->faker->Name(),
            'telefono_contacto' => $this->faker->PhoneNumber(),
            'nombre' => $this->faker->Company(),
            'tipo_documento' => 'C.I',
            'num_documento' => $this->faker->randomNumber(9),
            'direccion' => $this->faker->address(),
            'telefono' => $this->faker->PhoneNumber(),
            'email' => $this->faker->safeEmail()
        ];
    }
}
