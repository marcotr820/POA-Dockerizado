<?php

namespace Database\Factories;

use App\Models\Actividades;
use App\Models\Items;
use App\Models\Partidas;
use App\Models\TareasEspecificas;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Items::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'bien_servicio' => $this->faker->unique()->state(),
            'fecha_requerida' => $this->faker->date(),
            'presupuesto' => rand(100000, 999999),
            'partida_id' => Partidas::all()->random()->id,
            'actividad_id' => Actividades::all()->random()->id
        ];
    }
}
