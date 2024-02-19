<?php

namespace Database\Factories;

use App\Models\Pilares;
use Illuminate\Database\Eloquent\Factories\Factory;

class PilaresFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Pilares::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'nombre_pilar' => "pilar_".$this->faker->unique()->state(),
            'gestion_pilar' => $this->faker->year()

        ];
    }
}
