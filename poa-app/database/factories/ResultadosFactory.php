<?php

namespace Database\Factories;

use App\Models\Metas;
use App\Models\Resultados;
use Illuminate\Database\Eloquent\Factories\Factory;

class ResultadosFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Resultados::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'nombre_resultado' => "result_".$this->faker->unique()->city(),
            'meta_id' => Metas::all()->random()->id
        ];
    }
}
