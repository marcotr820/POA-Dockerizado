<?php

namespace Database\Seeders;

use App\Models\Trabajadores;
use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // administrador
        Usuario::create([
            'usuario' => '123456',
            'password' => Hash::make('654321'),
            'trabajador_id' => '1',
            'remember_token' => Str::random(10)
        ])->assignRole('ADMIN');

        Usuario::create([
            'usuario' => '3928208',
            'password' => Hash::make('123'),
            'trabajador_id' => '2',
            'remember_token' => Str::random(10)
        ])->assignRole('ADMIN');

        // planificador
        // Usuario::create([
        //     'usuario' => '1081273',
        //     'password' => Hash::make('123'),
        //     'trabajador_id' => '2',
        //     'remember_token' => Str::random(10)
        // ])->assignRole('PLANIFICADOR');

        // // trabajador
        // Usuario::create([
        //     'usuario' => '46428060',
        //     'password' => Hash::make('123'),
        //     'trabajador_id' => '3',
        //     'remember_token' => Str::random(10)
        // ])->assignRole('TRABAJADOR');

        // // GERENTE
        // Usuario::create([
        //     'usuario' => '12319351',
        //     'password' => Hash::make('123'),
        //     'trabajador_id' => '4',
        //     'remember_token' => Str::random(10)
        // ])->assignRole('GERENTE');

        // // TRABAJADOR GERENCIA TECNICA
        // // UNIDAD JEFATURA DE ADUCCION
        // Usuario::create([
        //     'usuario' => '32236840',
        //     'password' => Hash::make('123'),
        //     'trabajador_id' => '17',
        //     'remember_token' => Str::random(10)
        // ])->assignRole('TRABAJADOR');

        //despues de crear nuestro usuarios por defecto llamamos al factory para que se ejecute
        // Usuario::factory(1)->create();
    }
}