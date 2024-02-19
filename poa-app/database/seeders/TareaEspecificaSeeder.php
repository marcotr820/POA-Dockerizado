<?php

namespace Database\Seeders;

use App\Models\TareasEspecificas;
use Illuminate\Database\Seeder;

class TareaEspecificaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // PILAR 2022
        $TAR_ACT1 = [
            'REALIZAR COTIZACIONES',
            'CONTRATACIÓN DE MEDIOS DE COMUNICACIÓN',
            'PUBLICIDAD EN PRENSA ESCRITA'
        ];
        foreach($TAR_ACT1 as $tar){
            TareasEspecificas::create([
                'nombre_tarea' => $tar,
                'actividad_id' => '1'
            ]);
        }

        $TAR_ACT2 = [
            'REALIZAR TRIPTICOS',
            'ELABORACIÓN DE AFICHES',
            'MEJORAMIENTO DEL COMPONENTE SOCIAL DE LA EMPRESA CON LOS USUARIOS'
        ];
        foreach($TAR_ACT2 as $tar){
            TareasEspecificas::create([
                'nombre_tarea' => $tar,
                'actividad_id' => '2'
            ]);
        }

        $TAR_ACT3 = [
            'PROGRAMAR CORTES',
            'RECEPCIONAR TRAMITES',
            'ELABORACIÓN DE PROCEDIMIENTOS'
        ];
        foreach($TAR_ACT3 as $tar){
            TareasEspecificas::create([
                'nombre_tarea' => $tar,
                'actividad_id' => '3'
            ]);
        }

        $TAR_ACT4 = [
            'COMPRAR ACCESORIOS NECESARIOS',
            'RECEPCIÓ Y EVALUACIÓN DE DOCUMENTOS'
        ];
        foreach($TAR_ACT4 as $tar){
            TareasEspecificas::create([
                'nombre_tarea' => $tar,
                'actividad_id' => '4'
            ]);
        }
        
        $TAR_ACT5 = [
            'ALQUILAR EQUIPOS',
            'MANTENIMIENTO Y REPARACIÓN DE VEHIVULOS, MAQUINARIA Y EQUIPOS'
        ];
        foreach($TAR_ACT5 as $tar){
            TareasEspecificas::create([
                'nombre_tarea' => $tar,
                'actividad_id' => '5'
            ]);
        }

        $TAR_ACT6 = [
            'COMPRA DE COMBUSTIBLES LUBRICANTES Y DERIVADOS PARA CONSUMO',
            'COMPRA DE UTILES Y MATERIALES ELÉCTRONICOS'
        ];
        foreach($TAR_ACT6 as $tar){
            TareasEspecificas::create([
                'nombre_tarea' => $tar,
                'actividad_id' => '6'
            ]);
        }

        $TAR_ACT7 = [
            'MANTENIMIENTO Y REPARACIÓN DE INMUEBLES.',
            'OTROS GASTOS DE MANTENIMIENTO Y REPARACIÓN EN CANAL DE ADUCCIÓN.'
        ];
        foreach($TAR_ACT7 as $tar){
            TareasEspecificas::create([
                'nombre_tarea' => $tar,
                'actividad_id' => '7'
            ]);
        }

        $TAR_ACT8 = [
            'GASTOS DESTINADOS AL PAGO DE REFRIGERIOS AL PERSONAL DE LAS INSTITUCIONES PUBLICAS.',
            'OTRAS CONSTRUCCIONES Y MEJORAS DE BIENES PUBLICOS DE DOMINIO PRIVADO.'
        ];
        foreach($TAR_ACT8 as $tar){
            TareasEspecificas::create([
                'nombre_tarea' => $tar,
                'actividad_id' => '8'
            ]);
        }


        // PILAR 2023 *********************************************************************************************************
        TareasEspecificas::create([
            'nombre_tarea' => "COTIZAR",
            'actividad_id' => '9'
        ]);
        TareasEspecificas::create([
            'nombre_tarea' => "REALIZAR FIRMA DE CONVENIOS",
            'actividad_id' => '9'
        ]);
        TareasEspecificas::create([
            'nombre_tarea' => "REALIZAR INSPECCIÓN DE EQUIPOS",
            'actividad_id' => '10'
        ]);
        TareasEspecificas::create([
            'nombre_tarea' => "MANTENIMIENTO Y REPARACIÓN DE VEHÍCULOS, MAQUINARIA Y EQUIPOS",
            'actividad_id' => '10'
        ]);
        TareasEspecificas::create([
            'nombre_tarea' => "EJECUCIÓN DE TAREAS SEGUN LO PROGRAMADO",
            'actividad_id' => '11'
        ]);
        TareasEspecificas::create([
            'nombre_tarea' => "REALIZAR RESPUESTAS A RECLAMOS",
            'actividad_id' => '11'
        ]);
        TareasEspecificas::create([
            'nombre_tarea' => "CONTROLAR PARAMETROS DE PROCESOS PARA OPTIMIZAR LA PRODUCCIÓN DE AGUA",
            'actividad_id' => '12'
        ]);
        TareasEspecificas::create([
            'nombre_tarea' => "INSTALACIÓN Y PUESTA EN MARCHA DE ELECTROBOMBA",
            'actividad_id' => '12'
        ]);
        TareasEspecificas::create([
            'nombre_tarea' => "IMPLEMENTAR EL SITEMA DE GESTIÓN DE MANTENIMIENTO PREVENTIVO",
            'actividad_id' => '13'
        ]);
        TareasEspecificas::create([
            'nombre_tarea' => "REALIZAR LA CALIBRACIÓN DE INSTRUMENTOS",
            'actividad_id' => '13'
        ]);
        TareasEspecificas::create([
            'nombre_tarea' => "CONEXIÓN DE EQUIPOS DE PLANTA POTABILIZADORA",
            'actividad_id' => '14'
        ]);
        TareasEspecificas::create([
            'nombre_tarea' => "INSTALACIÓN DE SENSORES.",
            'actividad_id' => '14'
        ]);

        
        // TareasEspecificas::factory(7)->create();
    }
}
