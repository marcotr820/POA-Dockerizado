<?php

namespace Database\Seeders;

use App\Models\CortoPlazoAcciones;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class CortoPlazoAccionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // PILAR 2022
        $cpa2022 = [
            'IMPLEMENTACIÓN DE MEDIDAS COMPLEMENTARIAS',
            'SEGUIMIENTO A LOS DESEMBOLOS DE CONTRAPARTES LOCALES COMPROMETIDAS CON LA CIF, DEL GAMS / GADCH.'
        ];
        foreach ($cpa2022 as $val) {
            CortoPlazoAcciones::create([
                'gestion' => '2022',
                'accion_corto_plazo' => Str::upper($val),
                'resultado_esperado' => 25,
                'presupuesto_programado' => 250000,
                'fecha_inicio' => date('2022-02-03'),
                'fecha_fin' => date('2022-11-03'),
                'status' => 'aprobado',
                'trabajador_id' => '3',
                'pei_objetivo_especifico_id' => '1'
            ]);
        }

        // PILAR2023
        // GERENCIA TECNICA
        CortoPlazoAcciones::create([
            // id = 3
            'gestion' => '2023',
            'accion_corto_plazo' => Str::upper('IMPLEMENTAR MEJORAS EN EL PROCESO DE EXPANSIÓN DEL SERVICIO DE ALCANTARILLADO SANITARIO, A TRAVÉS DE PLANES ELABORADOS.'),
            'resultado_esperado' => 25,
            'presupuesto_programado' => 100000,
            'fecha_inicio' => date('2023-01-03'),
            'fecha_fin' => date('2023-12-03'),
            'status' => 'aprobado',
            'trabajador_id' => '17',
            'pei_objetivo_especifico_id' => '7'
        ]);

        // CortoPlazoAcciones::factory(20)->create();
    }
}
