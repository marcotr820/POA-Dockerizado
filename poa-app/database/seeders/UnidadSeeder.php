<?php

namespace Database\Seeders;

use App\Models\Unidades;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class UnidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $unidades_gerencia_general = [
            'sistemas informaticos',    //1
            'asesoria juridica',    //2
            'jefatura de planificacion y proyectos',    //3
            'relaciones publicas y gestion social',     //4
            'auditoria interna',    //5
            'odeco',    //6
            'gerencia general'  //7
        ];
        foreach($unidades_gerencia_general as $unidad){
            Unidades::create([
                'nombre_unidad' => Str::upper($unidad),
                'gerencia_id' => '1'
            ]);
        }

        $unidades_gerencia_administrativa = [
            'jefatura financiera y contable',   //8
            'jefatura administrativa y personal',   //9
            'gerencia administrativa'   //10
        ];
        foreach($unidades_gerencia_administrativa as $unidad){
            Unidades::create([
                'nombre_unidad' => Str::upper($unidad),
                'gerencia_id' => '2'
            ]);
        }

        $unidades_gerencia_comercial = [
            'jefatura atc y control mora',  //11
            'jefatura medicion y facturacion',  //12
            'gerencia comercial'    //13
        ];
        foreach($unidades_gerencia_comercial as $unidad){
            Unidades::create([
                'nombre_unidad' => Str::upper($unidad),
                'gerencia_id' => '3'
            ]);
        }
        
        $unidades_gerencia_tecnica = [
            'jefatura de aduccion',     //14
            'jefatura planta potabilizadora',   //15
            'jefatura red de agua', //16
            'jefatura red de alcantarillado',   //17
            'jefatura ptar',    //18
            'jefatura control de calidad',  //19
            'gerencia tecnica'  //20
        ];
        foreach($unidades_gerencia_tecnica as $unidad){
            Unidades::create([
                'nombre_unidad' => Str::upper($unidad),
                'gerencia_id' => '4'
            ]);
        }
    }
}
