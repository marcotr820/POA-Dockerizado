<?php

namespace Database\Factories;

use App\Models\Gerencias;
use App\Models\MedianoPlazoAcciones;
use App\Models\PeiObjetivosEspecificos;
use Illuminate\Database\Eloquent\Factories\Factory;

class PeiObjetivosEspecificosFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PeiObjetivosEspecificos::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'objetivo_institucional' => $this->faker->unique()->text($maxNbChars = 100),
            'ponderacion' => $this->faker->randomDigit(),
            'indicador_proceso' => $this->faker->text(),
            'gerencia_id' => Gerencias::all()->random()->id,
            'mediano_plazo_accion_id' => MedianoPlazoAcciones::all()->random()->id
        ];
    }
}
