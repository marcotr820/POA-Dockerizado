<?php

namespace Database\Factories;

use App\Models\Trabajadores;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UsuarioFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */

    //el factory debe tener el mismo nombre que el modelo =============== nombre del modelo + Factory

    protected $model = Usuario::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'usuario' => $this->faker->ean8(), 
            'password' => Hash::make('123'),
            'trabajador_id' => $this->faker->unique()->numberBetween(2, Trabajadores::count()),
            'remember_token' => Str::random(10)
        ];
    }
}
