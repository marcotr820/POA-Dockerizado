<?php

namespace Database\Seeders;

use App\Models\PeiObjetivosEspecificos;
use Illuminate\Database\Seeder;

class PeiObjetivoInstitucionalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // PILAR 2022
        // GERENCIA GENERAL
        PeiObjetivosEspecificos::create([
            //  id = 1
            'objetivo_institucional' => 'GESTIONAR LA EJECUCIÓN DEL PROYECTO SUCRE III Y SUCRE IV.',
            'ponderacion' => 50,
            'indicador_proceso' => 'MEJORAR LOS PROCESOS PARA LA TOMA DE DECISIONES.',
            'gerencia_id' => '1',
            'mediano_plazo_accion_id' => '3' 
        ]);
        // GERENCIA ADMINISTRATIVA
        PeiObjetivosEspecificos::create([
            //  id = 2
            'objetivo_institucional' => 'MEJORAR LOS PROCESOS DE ATENCIÓN AL CLIENTE EN LA EMPRESA.',
            'ponderacion' => 40,
            'indicador_proceso' => 'MEJORAR LAS ACTIVIDADES.',
            'gerencia_id' => '2',
            'mediano_plazo_accion_id' => '2' 
        ]);
        
        // GERENCIA COMERCIAL
        PeiObjetivosEspecificos::create([
            // id = 3
            'objetivo_institucional' => 'OPTIMIZAR LOS PROCESOS DE MEDICIÓN, FACTURACIÓN, COBRANZA Y ATENCIÓN DE USUARIOS.',
            'ponderacion' => 40,
            'indicador_proceso' => 'MEJORAR LAS ACTIVIDADES.',
            'gerencia_id' => '3',
            'mediano_plazo_accion_id' => '4' 
        ]);

        // GERENCIA TECNICA
        PeiObjetivosEspecificos::create([
            //  id = 4
            'objetivo_institucional' => 'INCREMENTAR LA EFICIENCIA OPERATIVA DEL SISTEMA DE AGUA Y ALCANTARILLADO PARA MEJORAR LA COBERTURA DEL SERVICIO',
            'ponderacion' => 50,
            'indicador_proceso' => 'MEJORAR LOS PROCESOS.',
            'gerencia_id' => '4',
            'mediano_plazo_accion_id' => '1' 
        ]);

        // PILAR 2023 *******************************************************************************************************************************
        // GERENCIA GENERAL
        PeiObjetivosEspecificos::create([
            //  id = 5
            'objetivo_institucional' => 'LIDERAR EL PROCESO DE FORTALECIMIENTO EMPRESARIAL PARA MEJORAR EL DESEMPEÑO EN TODAS LAS AREAS Y UNIDADES.',
            'ponderacion' => 25,
            'indicador_proceso' => 20,
            'gerencia_id' => '1',
            'mediano_plazo_accion_id' => '5' 
        ]);
        PeiObjetivosEspecificos::create([
            //  id = 6
            'objetivo_institucional' => 'DISEÑAR UNA ESTRUCTURA EMPRESARIAL NOVEDOSA QUE PERMITA LA EXPANSIÓN DEL SERVICIO Y LA AUTOSOSTENIBILIDAD.',
            'ponderacion' => 25,
            'indicador_proceso' => 20,
            'gerencia_id' => '1',
            'mediano_plazo_accion_id' => '5' 
        ]);

        // GERENCIA TECNICA
        PeiObjetivosEspecificos::create([
            //  id = 7
            'objetivo_institucional' => 'IMPLEMENTACIÓN DEL PROGRAMA DE RENOVACIÓN E INSTALACIÓN DE MEDIDORES A TRAVEZ DEL BANCO DE MEDIDORES.',
            'ponderacion' => 50,
            'indicador_proceso' => 'MEJORAR LOS PROCESOS.',
            'gerencia_id' => '4',
            'mediano_plazo_accion_id' => '5' 
        ]);

        // GERENCIA COMERCIAL
        PeiObjetivosEspecificos::create([
            // id = 9
            'objetivo_institucional' => 'OPTIMIZAR LOS PROCESOS  DE MEDICION, FACTURACIÓN, COBRANZA Y ATENCION DE USUARIOS, PARA GARANTIZAR LA SOSTENIBILIDAD ECONOMICA DE LA EMPRESA.',
            'ponderacion' => 25,
            'indicador_proceso' => 20,
            'gerencia_id' => '3',
            'mediano_plazo_accion_id' => '6' 
        ]);

        // GERENCIA ADMINISTRATIVA
        PeiObjetivosEspecificos::create([
            //  id = 10
            'objetivo_institucional' => 'OPTIMIZAR LA ADMINISTRACIÓN DE RECURSOS ECONÓMICOS Y HUMANOS A TRAVÉS DE LA IMPLEMENTACIÓN DE MEJORAS EN LOS SISTEMAS DE ADMINISTRACIÓN DE PERSONAL Y DE ADMINISTRACIÓN DE BIENES Y SERVICIOS.',
            'ponderacion' => 25,
            'indicador_proceso' => 30,
            'gerencia_id' => '2',
            'mediano_plazo_accion_id' => '5' 
        ]);
    }
}
