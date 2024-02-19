<?php

namespace Database\Factories;

use App\Models\Partidas;
use Illuminate\Database\Eloquent\Factories\Factory;

class PartidasFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Partidas::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nombre_partida' => strtoupper($this->faker->safeEmail()),
            'codigo_partida' => rand(10000, 99999),
            'tipo_partida' => $this->faker->randomElement(['FUNCIONAMIENTO', 'INVERSION'])
        ];
    }
}
