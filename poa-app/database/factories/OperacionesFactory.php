<?php

namespace Database\Factories;

use App\Models\Operaciones;
use App\Models\CortoPlazoAcciones;
use Illuminate\Database\Eloquent\Factories\Factory;

class OperacionesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Operaciones::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nombre_operacion' => 'operacion'.$this->faker->citySuffix(),
            'corto_plazo_accion_id' => CortoPlazoAcciones::get()->random()->id
        ];
    }
}
