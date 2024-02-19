<?php

namespace Database\Factories;

use App\Models\CortoPlazoAcciones;
use App\Models\PeiObjetivosEspecificos;
use App\Models\Trabajadores;
use Illuminate\Database\Eloquent\Factories\Factory;

class CortoPlazoAccionesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CortoPlazoAcciones::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'gestion' => $this->faker->year(),
            'accion_corto_plazo' => 'corto_plazo'.$this->faker->unique()->slug(),
            'resultado_esperado' => $this->faker->randomDigit(),
            'presupuesto_programado' => $this->faker->ean8(),
            'fecha_inicio' => $this->faker->date(),
            'fecha_fin' => $this->faker->date(),
            'trabajador_id' => Trabajadores::all()->random()->id,
            'pei_objetivo_especifico_id' => PeiObjetivosEspecificos::all()->random()->id,
        ];
    }
}
