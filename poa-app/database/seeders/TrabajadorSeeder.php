<?php

namespace Database\Seeders;

use App\Models\Trabajadores;
use App\Models\Unidades;
use Illuminate\Database\Seeder;

class TrabajadorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ADMIN
        Trabajadores::create([
            'documento' => '123456',
            'nombre' => 'SUPERADMINISTRADOR',
            'cargo' => 'SUPERADMINISTRADOR',
            'poa_status' => '0',
            'poa_evaluacion' => '0',
            'unidad_id' => '1'
        ]);

        Trabajadores::create([
            'documento' => '3928208',
            'nombre' => 'JUAN PABLO RAYA ROMERO',
            'cargo' => 'JEFE DE SISTEMAS INFORMATICOS',
            'poa_status' => '0',
            'poa_evaluacion' => '0',
            'unidad_id' => '1'
        ]);

        //PLANIFICADOR GERENCIA TECNICA
        // Trabajadores::create([
        //     'documento' => '1081273',
        //     'nombre' => 'GUSTAVO IGNACIO MILOS MARQUEZ',
        //     'cargo' => 'JEFE DE PLANIFICACIÓN Y PROYECTOS',
        //     'poa_status' => '0',
        //     'poa_evaluacion' => '0',
        //     'unidad_id' => '3'  //jefatura de planificacion y proyectos
        // ]);

        // // TRABAJADOR
        // Trabajadores::create([
        //     'documento' => '46428060',
        //     'nombre' => 'PEDRO ROJAS BARRON',
        //     'cargo' => 'TECNICO DE SISTEMAS',
        //     'poa_status' => '1',
        //     'poa_evaluacion' => '1',
        //     'unidad_id' => '5'  //AUDITORIA INTERNA
        // ]);

        // // GERENTE GENERAL
        // Trabajadores::create([
        //     'documento' => '12319351',
        //     'nombre' => 'WILHELM PIEROLA ITURRALDE',
        //     'cargo' => 'GERENTE GENERAL',
        //     'poa_status' => '1',
        //     'poa_evaluacion' => '1',
        //     'unidad_id' => '7'
        // ]);

        // // GERENTE ADMINISTRATIVO FINANCIERO
        // Trabajadores::create([
        //     'documento' => '12319351',
        //     'nombre' => 'ERNESTO SEJAS',
        //     'cargo' => 'GERENTE ADMINISTRATIVO Y FINANCIERO',
        //     'poa_status' => '0',
        //     'poa_evaluacion' => '0',
        //     'unidad_id' => '10'
        // ]);

        // // GERENTE TECNICO
        // Trabajadores::create([
        //     'documento' => '12319351',
        //     'nombre' => 'ENZO ARNALDO PORCEL ARANDIA',
        //     'cargo' => 'GERENTE TECNICO',
        //     'poa_status' => '0',
        //     'poa_evaluacion' => '0',
        //     'unidad_id' => '20'
        // ]);

        // // GERENTE COMERCIAL
        // Trabajadores::create([
        //     'documento' => '12319351',
        //     'nombre' => 'RUDY MEJIA CHAMOSO',
        //     'cargo' => 'GERENTE COMERCIAL',
        //     'poa_status' => '0',
        //     'poa_evaluacion' => '0',
        //     'unidad_id' => '13'
        // ]);

        // // ENCARGADO DE SISTEMAS GERENCIA GENERAL
        // Trabajadores::create([
        //     'documento' => '3928208',
        //     'nombre' => 'JUAN PABLO RAYA ROMERO',
        //     'cargo' => 'JEFE DE SISTEMAS INFORMATICOS',
        //     'poa_status' => '0',
        //     'poa_evaluacion' => '0',
        //     'unidad_id' => '1'
        // ]);

        // // ENCARGADO ASESORIA JURIDICA INTERNA GERENCIA GENERAL
        // Trabajadores::create([
        //     'documento' => '1578456',
        //     'nombre' => 'JOSE LUIS MAMANI',
        //     'cargo' => 'ASESOR JURIDICO',
        //     'poa_status' => '0',
        //     'poa_evaluacion' => '0',
        //     'unidad_id' => '2'
        // ]);

        // // ENCARGADO RELACIONES PUBLICAS GERENCIA GENERAL
        // Trabajadores::create([
        //     'documento' => '37104585',
        //     'nombre' => 'YHOJAN ROBERTO VEDIA ZUÑIGA',
        //     'cargo' => 'RELACIONADOR PUBLICO Y GESTION PUBLICA',
        //     'poa_status' => '0',
        //     'poa_evaluacion' => '0',
        //     'unidad_id' => '4'
        // ]);

        // // AUDITORIA INTERNA GERENCIA GENERAL
        // Trabajadores::create([
        //     'documento' => '36153072',
        //     'nombre' => 'JUAN RAMON ESQUIVER RIVERA',
        //     'cargo' => 'AUDITOR INTERNO',
        //     'poa_status' => '0',
        //     'poa_evaluacion' => '0',
        //     'unidad_id' => '5'
        // ]);

        // // ODECO GERENCIA GENERAL
        // Trabajadores::create([
        //     'documento' => '15635193',
        //     'nombre' => 'JAVIER RAMIRO POMA TORRES',
        //     'cargo' => 'ENCARGADO PLATAFORMA ODECO',
        //     'poa_status' => '0',
        //     'poa_evaluacion' => '0',
        //     'unidad_id' => '6'
        // ]);

        // // jefatura financiera y contable gerencia administrativa
        // Trabajadores::create([
        //     'documento' => '20561945',
        //     'nombre' => 'GERTRUDIS DORIS VARGAS MENDOZA',
        //     'cargo' => 'JEFE FINANCIERO CONTABLE',
        //     'poa_status' => '0',
        //     'poa_evaluacion' => '0',
        //     'unidad_id' => '8'
        // ]);

        // // JEFATURA ADMINISTRATIVA Y DE PERSONAL gerencia administrativa
        // Trabajadores::create([
        //     'documento' => '20593193',
        //     'nombre' => 'TEOFILO VARGAS CABA',
        //     'cargo' => 'JEFE ADMINISTRATIVO Y DE PERSONAL',
        //     'poa_status' => '0',
        //     'poa_evaluacion' => '0',
        //     'unidad_id' => '9'
        // ]);

        // // JEFATURA ATC Y CONTROL MORA GERENCIA COMERCIAL
        // Trabajadores::create([
        //     'documento' => '6587125',
        //     'nombre' => 'LETICIA DAZA BARRON',
        //     'cargo' => 'JEFE SERVICIOS AL CLIENTE Y CONTROL MORA',
        //     'poa_status' => '0',
        //     'poa_evaluacion' => '0',
        //     'unidad_id' => '11'
        // ]);

        // // JEFATURA DE MEDICION Y FACTURACION GERENCIA COMERCIAL
        // Trabajadores::create([
        //     'documento' => '9941769',
        //     'nombre' => 'RENE FREDDY IGLESIAS IPORRE',
        //     'cargo' => 'JEFE DE MEDICIÓN Y FACTURACIÓN',
        //     'poa_status' => '0',
        //     'poa_evaluacion' => '0',
        //     'unidad_id' => '12'
        // ]);

        // // JEFATURA DE ADUCCION GERENCIA TECNICA
        // Trabajadores::create([
        //     'documento' => '32236840',
        //     'nombre' => 'VLADIMIR VALDA VARGAS',
        //     'cargo' => 'JEFE CAPTACIÓN Y ADUCCIÓN',
        //     'poa_status' => '1',
        //     'poa_evaluacion' => '1',
        //     'unidad_id' => '14'
        // ]);

        // // JEFATURA PLANTA POTABILIZADORA GERENCIA TECNICA
        // Trabajadores::create([
        //     'documento' => '1954745',
        //     'nombre' => 'SABINO CHAVEZ JULIO',
        //     'cargo' => 'JEFE DE PLANTA POTABILIZADORA',
        //     'poa_status' => '0',
        //     'poa_evaluacion' => '0',
        //     'unidad_id' => '15'
        // ]);

        // // JEFATURA RED DE AGUA GERENCIA TECNICA
        // Trabajadores::create([
        //     'documento' => '1458965',
        //     'nombre' => 'PRIMO CARO SERRUDO',
        //     'cargo' => 'JEFE DE RED DE AGUA',
        //     'poa_status' => '0',
        //     'poa_evaluacion' => '0',
        //     'unidad_id' => '16'
        // ]);

        // // JEFATURA RED DE ALCANTARRILLADO
        // Trabajadores::create([
        //     'documento' => '10209451',
        //     'nombre' => 'JUAN JOSE JIMINEZ LASCANO',
        //     'cargo' => 'JEFE DE RED DE ALCANTARILLADO',
        //     'poa_status' => '0',
        //     'poa_evaluacion' => '0',
        //     'unidad_id' => '17'
        // ]);

        // // JEFATURA PTAR GERENCIA TECNICA
        // Trabajadores::create([
        //     'documento' => '25987471',
        //     'nombre' => 'ALFONSO CARDOZO SERRUDO',
        //     'cargo' => 'ENCARGADO PTAR',
        //     'poa_status' => '0',
        //     'poa_evaluacion' => '0',
        //     'unidad_id' => '18'
        // ]);

        // // JEFATURA CONTROL DE CALIDAD GERENCIA TECNICA
        // Trabajadores::create([
        //     'documento' => '12722571',
        //     'nombre' => 'ROMER JOSE FIDEL MENDEZ BARRON',
        //     'cargo' => 'JEFE DE CONTROL DE CALIDAD',
        //     'poa_status' => '0',
        //     'poa_evaluacion' => '0',
        //     'unidad_id' => '19'
        // ]);

        // Trabajadores::factory(4)->create();
    }
}
