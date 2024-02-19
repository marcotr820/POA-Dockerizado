<?php

namespace Database\Factories;

use App\Models\CortoPlazoAcciones;
use App\Models\Evaluaciones;
use Illuminate\Database\Eloquent\Factories\Factory;

class EvaluacionesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Evaluaciones::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'resultado_esperado' => rand(5,25),
            'resultado_logrado' => rand(5,25),
            'eficacia' => rand(1,10),
            'presupuesto' => rand(100000, 500000),
            'presupuesto_ejecutado' => rand(50000, 100000),
            'ejecucion' => rand(1,10),
            'relacion_avance' => rand(1,10),
            'trimestre' => $this->faker->unique()->name(),
            'corto_plazo_accion_id' => CortoPlazoAcciones::all()->random()->id 
        ];
    }
}
