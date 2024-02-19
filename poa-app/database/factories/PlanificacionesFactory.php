<?php

namespace Database\Factories;

use App\Models\CortoPlazoAcciones;
use App\Models\Planificaciones;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlanificacionesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Planificaciones::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'primer_trimestre' => rand(1, 25),
            'segundo_trimestre' => rand(1, 25),
            'tercer_trimestre' => rand(1, 25),
            'cuarto_trimestre' => rand(1, 25),
            'corto_plazo_accion_id' => $this->faker->unique()->numberBetween(1, CortoPlazoAcciones::count()),
            // 'corto_plazo_accion_id' => $this->faker->unique()->numberBetween(1, CortoPlazoAcciones::count()),
        ];
    }
}
