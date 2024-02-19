<?php

namespace Database\Seeders;

use App\Models\Metas;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class MetaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // pilar 2022
        Metas::create([
            // id 1
            'codigo_meta' => 22,
            'nombre_meta' => Str::upper('El 100% de las bolivianas y los bolivianos cuentan con servicios de agua y alcantarillado sanitario'),
            'pilar_id' => '1'
        ]);

        // pilar 2023
        Metas::create([
            // id 2
            'codigo_meta' => 25,
            'nombre_meta' => Str::upper('El 100% de las bolivianas y los bolivianos cuentan con servicios de agua y alcantarillado sanitario'),
            'pilar_id' => '2'
        ]);
    }
}
