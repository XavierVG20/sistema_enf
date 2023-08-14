<?php

namespace Database\Factories;
use App\Models\Persona;

use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Factories\Factory;

class PersonaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Persona::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->name(),
            'tipo_documento' => 'C.I',
            'num_documento' => $this->faker->randomNumber(9),
            'direccion' => $this->faker->address(),
            'telefono' => $this->faker->PhoneNumber(),
            'email' => $this->faker->safeEmail()
        ];
    }
}
