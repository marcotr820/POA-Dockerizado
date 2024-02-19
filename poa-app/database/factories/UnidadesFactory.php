<?php

namespace Database\Factories;

use App\Models\Unidades;
use App\Models\Gerencias;
use Illuminate\Database\Eloquent\Factories\Factory;

class UnidadesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Unidades::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'nombre_unidad' => $this->faker->unique()->jobTitle(),
            
            'gerencia_id' => Gerencias::all()->random()->id,
        ];
    }
}
