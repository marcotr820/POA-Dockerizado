<?php

namespace Database\Seeders;

use App\Models\Planificaciones;
use Illuminate\Database\Seeder;

class PlanificacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // GESTION 2022
        Planificaciones::create([
            'primer_trimestre' => 20,
            'segundo_trimestre' => 30,
            'tercer_trimestre' => 40,
            'cuarto_trimestre' => 10,
            'corto_plazo_accion_id' => 1
        ]);
        Planificaciones::create([
            'primer_trimestre' => 60,
            'segundo_trimestre' => 20,
            'tercer_trimestre' => 10,
            'cuarto_trimestre' => 10,
            'corto_plazo_accion_id' => 2
        ]);

        // // GESTION 2023
        // jefatura aduccion G.TECNICA
        Planificaciones::create([
            'primer_trimestre' => 20,
            'segundo_trimestre' => 20,
            'tercer_trimestre' => 50,
            'cuarto_trimestre' => 10,
            'corto_plazo_accion_id' => 3
        ]);
    }
}
