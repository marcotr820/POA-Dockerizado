<?php

namespace Database\Factories;

use App\Models\Actividades;
use App\Models\TareasEspecificas;
use Illuminate\Database\Eloquent\Factories\Factory;

class TareasEspecificasFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TareasEspecificas::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nombre_tarea' => 'tar_especif'.$this->faker->unique()->streetAddress(),
            'actividad_id' => Actividades::all()->random()->id
        ];
    }
}
