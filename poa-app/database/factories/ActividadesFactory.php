<?php

namespace Database\Factories;

use App\Models\Actividades;
use App\Models\Operaciones;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActividadesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Actividades::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nombre_actividad' => 'actividad'.$this->faker->unique()->streetAddress(),
            'resultado_esperado' => $this->faker->text(),
            'operacion_id' => Operaciones::all()->random()->id
        ];
    }
}
