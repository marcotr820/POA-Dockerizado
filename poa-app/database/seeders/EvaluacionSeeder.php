<?php

namespace Database\Seeders;

use App\Models\Evaluaciones;
use Illuminate\Database\Seeder;

class EvaluacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 2022
        Evaluaciones::create([
            "resultado_esperado" => 20,
            "resultado_logrado" => 20,
            "eficacia" => 100,
            "presupuesto" => 250000,
            "presupuesto_ejecutado" => 100000,
            "ejecucion" => 40,
            "relacion_avance" => 0.2,
            "trimestre" => "primer_trimestre",
            "corto_plazo_accion_id" => 1
        ]);
        Evaluaciones::create([
            "resultado_esperado" => 30,
            "resultado_logrado" => 30,
            "eficacia" => 100,
            "presupuesto" => 150000,
            "presupuesto_ejecutado" => 70000,
            "ejecucion" => 28,
            "relacion_avance" => 0.5,
            "trimestre" => "segundo_trimestre",
            "corto_plazo_accion_id" => 1
        ]);
        Evaluaciones::create([
            "resultado_esperado" => 40,
            "resultado_logrado" => 35,
            "eficacia" => 87.5,
            "presupuesto" => 80000,
            "presupuesto_ejecutado" => 50000,
            "ejecucion" => 20,
            "relacion_avance" => 0.7,
            "trimestre" => "tercer_trimestre",
            "corto_plazo_accion_id" => 1
        ]);
        Evaluaciones::create([
            "resultado_esperado" => 10,
            "resultado_logrado" => 10,
            "eficacia" => 10,
            "presupuesto" => 30000,
            "presupuesto_ejecutado" => 30000,
            "ejecucion" => 12,
            "relacion_avance" => 0.9,
            "trimestre" => "cuarto_trimestre",
            "corto_plazo_accion_id" => 1
        ]);

        // 2023
        // ACCION JEFATURA ADUCCION G.TECNICA
        Evaluaciones::create([
            "resultado_esperado" => 20,
            "resultado_logrado" => 20,
            "eficacia" => 100,
            "presupuesto" => 100000,
            "presupuesto_ejecutado" => 30000,
            "ejecucion" => 30,
            "relacion_avance" => 0.2,
            "trimestre" => "primer_trimestre",
            "corto_plazo_accion_id" => 3
        ]);
        Evaluaciones::create([
            "resultado_esperado" => 20,
            "resultado_logrado" => 19,
            "eficacia" => 95,
            "presupuesto" => 70000,
            "presupuesto_ejecutado" => 20000,
            "ejecucion" => 20,
            "relacion_avance" => 0.5,
            "trimestre" => "segundo_trimestre",
            "corto_plazo_accion_id" => 3
        ]);
        Evaluaciones::create([
            "resultado_esperado" => 50,
            "resultado_logrado" => 45,
            "eficacia" => 90,
            "presupuesto" => 50000,
            "presupuesto_ejecutado" => 40000,
            "ejecucion" => 40,
            "relacion_avance" => 0.7,
            "trimestre" => "tercer_trimestre",
            "corto_plazo_accion_id" => 3
        ]);
        Evaluaciones::create([
            "resultado_esperado" => 10,
            "resultado_logrado" => 10,
            "eficacia" => 100,
            "presupuesto" => 10000,
            "presupuesto_ejecutado" => 10000,
            "ejecucion" => 10,
            "relacion_avance" => 0.9,
            "trimestre" => "cuarto_trimestre",
            "corto_plazo_accion_id" => 3
        ]);
    }
}
