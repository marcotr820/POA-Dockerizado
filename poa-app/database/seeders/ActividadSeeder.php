<?php

namespace Database\Seeders;

use App\Models\Actividades;
use Illuminate\Database\Seeder;

class ActividadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // PILAR 2022
        $ACT_OP1 = [
            'CONTRATACIÓN DE EMPRESA CONSULTORA',
            'REUNIONES DE COORDICACIÓN DE PROYECTOS'
        ];
        foreach($ACT_OP1 as $act){
            Actividades::create([
                'nombre_actividad' => $act,
                'resultado_esperado' => rand(10,90),
                'operacion_id' => '1'
            ]);
        }

        $ACT_OP2 = [
            'IMPLEMENTACION DE TECNICAS PARA MEJORAR EL SISTEMA DE LECTURAS',
            'REALIZAR PROGRAMACIÓN DE CORTES Y RECONEXIONES'
        ];
        foreach($ACT_OP2 as $act){
            Actividades::create([
                'nombre_actividad' => $act,
                'resultado_esperado' => rand(10,90),
                'operacion_id' => '2'
            ]);
        }

        $ACT_OP3 = [
            'ELABORACIÓN DE INFORMES DE EVALUACIÓN DE LA EMPRESA',
            'COORDINACION DE LOS PROCESOS DE GESTIÓN'
        ];
        foreach($ACT_OP3 as $act){
            Actividades::create([
                'nombre_actividad' => $act,
                'resultado_esperado' => rand(10,90),
                'operacion_id' => '3'
            ]);
        }

        $ACT_OP4 = [
            'RECEPCION DE TRAMITES DE INSTALACIONES NUEVAS',
            'INFORMACIÓN DE OTROS SERVICIOS Y TRAMITES'
        ];
        foreach($ACT_OP4 as $act){
            Actividades::create([
                'nombre_actividad' => $act,
                'resultado_esperado' => rand(10,90),
                'operacion_id' => '4'
            ]);
        }


        // PILAR 2023 ******************************************************************************************************
        Actividades::create([
            // id = 9
            'nombre_actividad' => "CONTRATAR  SERVICIOS NO PERSONALES",
            'resultado_esperado' => rand(10,90),
            'operacion_id' => '5'
        ]);
        Actividades::create([
            // id = 10
            'nombre_actividad' => "ADQUIRIR MATERIALES Y SUMINISTROS",
            'resultado_esperado' => rand(10,90),
            'operacion_id' => '5'
        ]);
        Actividades::create([
            // id = 11
            'nombre_actividad' => "ELABORAR CRONOGRAMA DE ACTIVIDADES PARA LA OPERACIÓN",
            'resultado_esperado' => rand(10,90),
            'operacion_id' => '6'
        ]);
        Actividades::create([
            // id = 12
            'nombre_actividad' => "REALIZAR PLANIFICACIÓN CONTROL Y SEGUIMIENTO",
            'resultado_esperado' => rand(10,90),
            'operacion_id' => '6'
        ]);
        Actividades::create([
            // id = 13
            'nombre_actividad' => "OPTIMIZAR EL TRANSPORTE DE AGUA CRUDA A TODAS LAS AREAS.",
            'resultado_esperado' => rand(10,90),
            'operacion_id' => '7'
        ]);
        Actividades::create([
            // id = 14
            'nombre_actividad' => "GARANTIZAR LA OPERACIÓN Y MANTENIMIENTO DE LOS SISTEMAS DE ADUCCIÓN.",
            'resultado_esperado' => rand(10,90),
            'operacion_id' => '7'
        ]);

        // Actividades::factory(6)->create();
    }
}
