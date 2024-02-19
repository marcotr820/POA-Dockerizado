<?php

namespace Database\Seeders;

use App\Models\Resultados;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class ResultadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // pilar 2022
        Resultados::create([
            // id = 1
            'codigo_resultado' => 12,
            'nombre_resultado' => Str::upper('El 90% de la población urbana cuenta con servicios de agua potable.'),
            'meta_id' => '1'
        ]);

        Resultados::create([
            // id = 2
            'codigo_resultado' => 11,
            'nombre_resultado' => Str::upper('El 67% de la población urbana cuenta con servicios de alcantarillado y saneamiento.'),
            'meta_id' => '1'
        ]);

        // pilar 2023
        Resultados::create([
            // id = 3
            'codigo_resultado' => 10,
            'nombre_resultado' => Str::upper('El 95% de la población urbana cuenta con servicios de agua potable.'),
            'meta_id' => '2'
        ]);
        
    }
}
