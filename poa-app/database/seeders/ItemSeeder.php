<?php

namespace Database\Seeders;

use App\Models\Items;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // PILAR 2022
        Items::create([
            'bien_servicio' => 'MEJORAMIENTO DE LA IMAGEN INSTITUCIONAL DE LA EMPRESA',
            'fecha_requerida' => '2022-05-02',
            'presupuesto' => '40000',
            'partida_id' => '1',
            'actividad_id' => '1'
        ]);
        Items::create([
            'bien_servicio' => 'CARTILLAS',
            'fecha_requerida' => '2022-05-02',
            'presupuesto' => '5000',
            'partida_id' => '1',
            'actividad_id' => '1'
        ]);
        Items::create([
            'bien_servicio' => 'COMPUTADORA DE ESCRITORIO',
            'fecha_requerida' => '2022-05-02',
            'presupuesto' => '9000',
            'partida_id' => '1',
            'actividad_id' => '1'
        ]);
        Items::create([
            'bien_servicio' => 'PUBLICIDAD EN RADIO Y TELEVISIÓN',
            'fecha_requerida' => '2022-05-02',
            'presupuesto' => '25000',
            'partida_id' => '30',
            'actividad_id' => '2'
        ]);
        Items::create([
            'bien_servicio' => 'REFRIGERIOS',
            'fecha_requerida' => '2022-05-02',
            'presupuesto' => '15000',
            'partida_id' => '45',
            'actividad_id' => '2'
        ]);
        Items::create([
            'bien_servicio' => 'LLAVEROS, REGLAS, BOLIGRAFOS Y OTROS',
            'fecha_requerida' => '2022-05-02',
            'presupuesto' => '7000',
            'partida_id' => '60',
            'actividad_id' => '2'
        ]);
        Items::create([
            'bien_servicio' => 'BATERIAS ADICIONALES PARA TABLETS',
            'fecha_requerida' => '2022-05-02',
            'presupuesto' => '15000',
            'partida_id' => '75',
            'actividad_id' => '3'
        ]);
        Items::create([
            'bien_servicio' => 'VEHICULOS PARA INSPECTORES DE INCONSISTENCIAS',
            'fecha_requerida' => '2022-05-02',
            'presupuesto' => '55000',
            'partida_id' => '85',
            'actividad_id' => '3'
        ]);
        Items::create([
            'bien_servicio' => 'EQUIPOS DE COMPUTACIÓN',
            'fecha_requerida' => '2022-05-02',
            'presupuesto' => '20000',
            'partida_id' => '95',
            'actividad_id' => '4'
        ]);
        Items::create([
            'bien_servicio' => 'COMPRA DE ACCESORIOS PARA INSTALACIONES',
            'fecha_requerida' => '2022-05-02',
            'presupuesto' => '19000',
            'partida_id' => '97',
            'actividad_id' => '4'
        ]);
        Items::create([
            'bien_servicio' => 'CONSULTORIA POR PRODUCTO',
            'fecha_requerida' => '2022-05-02',
            'presupuesto' => '40000',
            'partida_id' => '105',
            'actividad_id' => '4'
        ]);


        // ITEMS ACCION CORTO PLAZO
        Items::create([
            'bien_servicio' => 'ALQUILER DE GRUA PARA MANTENIMIENTO DE EQUIPOS ILUMINARIAS ETC.',
            'fecha_requerida' => '2022-05-02',
            'presupuesto' => '40000',
            'partida_id' => '105',
            'actividad_id' => '5'
        ]);
        Items::create([
            'bien_servicio' => 'MANTENIMIENTO PREVENTIVO DE EQUIPOS.',
            'fecha_requerida' => '2022-05-02',
            'presupuesto' => '50000',
            'partida_id' => '120',
            'actividad_id' => '5'
        ]);
        Items::create([
            'bien_servicio' => 'MANTENIMIENTO PREVENTIVO DE BOMBAS DE LODO.',
            'fecha_requerida' => '2022-05-02',
            'presupuesto' => '20000',
            'partida_id' => '120',
            'actividad_id' => '6'
        ]);
        Items::create([
            'bien_servicio' => 'REBOBINADO DE MOTORES ELECTRICOS.',
            'fecha_requerida' => '2022-05-02',
            'presupuesto' => '20000',
            'partida_id' => '135',
            'actividad_id' => '6'
        ]);
        Items::create([
            'bien_servicio' => 'DIESEL OIL.',
            'fecha_requerida' => '2022-05-02',
            'presupuesto' => '10000',
            'partida_id' => '135',
            'actividad_id' => '7'
        ]);
        Items::create([
            'bien_servicio' => 'GASOLINA PARA VEHICULOS.',
            'fecha_requerida' => '2022-05-02',
            'presupuesto' => '30000',
            'partida_id' => '145',
            'actividad_id' => '7'
        ]);
        Items::create([
            'bien_servicio' => 'SERVICIO TELEFONICO.',
            'fecha_requerida' => '2022-05-02',
            'presupuesto' => '70000',
            'partida_id' => '145',
            'actividad_id' => '8'
        ]);
        Items::create([
            'bien_servicio' => 'TONER PARA IMPRESORAS DE DIFERENTES CARACTERISTICAS.',
            'fecha_requerida' => '2022-05-02',
            'presupuesto' => '10000',
            'partida_id' => '160',
            'actividad_id' => '8'
        ]);

        // PILAR 2023 ******************************************************************************************************
        Items::create([
            'bien_servicio' => "HERRAMIENTAS PARA COMPACTADO.",
            'fecha_requerida' => '2023-05-02',
            'presupuesto' => '3000',
            'partida_id' => '1',
            'actividad_id' => '9'
        ]);
        Items::create([
            'bien_servicio' => "SERVICIO DE CORTADO Y DEMOLICIÓN",
            'fecha_requerida' => '2023-07-02',
            'presupuesto' => '20000',
            'partida_id' => '20',
            'actividad_id' => '9'
        ]);
        Items::create([
            'bien_servicio' => "RELLENO Y COMPACTADO DE PAVIMENTO",
            'fecha_requerida' => '2023-06-02',
            'presupuesto' => '25000',
            'partida_id' => '35',
            'actividad_id' => '10'
        ]);
        Items::create([
            'bien_servicio' => "MATERIALES DE ESCRITORIO VARIOS.",
            'fecha_requerida' => '2023-06-02',
            'presupuesto' => '10000',
            'partida_id' => '50',
            'actividad_id' => '10'
        ]);
        Items::create([
            'bien_servicio' => "PRODUCTOS QUIMICOS.",
            'fecha_requerida' => '2023-06-02',
            'presupuesto' => '400',
            'partida_id' => '65',
            'actividad_id' => '11'
        ]);
        Items::create([
            'bien_servicio' => "SULFATO DE ALUMINIO.",
            'fecha_requerida' => '2023-06-02',
            'presupuesto' => '600',
            'partida_id' => '80',
            'actividad_id' => '11'
        ]);
        Items::create([
            'bien_servicio' => "ENERGIA ELECTRICA Y COMBUSTIBLE.",
            'fecha_requerida' => '2023-06-02',
            'presupuesto' => '5000',
            'partida_id' => '95',
            'actividad_id' => '12'
        ]);
        Items::create([
            'bien_servicio' => "MATERIALES ELECTRONICOS.",
            'fecha_requerida' => '2023-06-02',
            'presupuesto' => '10000',
            'partida_id' => '110',
            'actividad_id' => '12'
        ]);
        Items::create([
            'bien_servicio' => "CALIBRACIÓN DE HERRAMIENTAS.",
            'fecha_requerida' => '2023-06-02',
            'presupuesto' => '3000',
            'partida_id' => '125',
            'actividad_id' => '13'
        ]);
        Items::create([
            'bien_servicio' => "CAPACITACIÓN DE PERSONAL.",
            'fecha_requerida' => '2023-06-02',
            'presupuesto' => '4500',
            'partida_id' => '140',
            'actividad_id' => '13'
        ]);
        Items::create([
            'bien_servicio' => "CONTRATACIÓN DE PERSONAL DE LABORATORIO.",
            'fecha_requerida' => '2023-06-02',
            'presupuesto' => '8500',
            'partida_id' => '155',
            'actividad_id' => '14'
        ]);
        Items::create([
            'bien_servicio' => "EQUIPOS DE LABORATORIO.",
            'fecha_requerida' => '2023-06-02',
            'presupuesto' => '10000',
            'partida_id' => '170',
            'actividad_id' => '14'
        ]);

        

        // Items::factory(5)->create();
    }
}
