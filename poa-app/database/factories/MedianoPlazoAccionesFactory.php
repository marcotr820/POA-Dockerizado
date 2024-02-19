<?php

namespace Database\Factories;

use App\Models\MedianoPlazoAcciones;
use App\Models\Resultados;
use Illuminate\Database\Eloquent\Factories\Factory;

class MedianoPlazoAccionesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MedianoPlazoAcciones::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'accion_mediano_plazo' => "acc_med_".$this->faker->unique()->country(),
            'resultado_id' => Resultados::all()->random()->id
        ];
    }
}
