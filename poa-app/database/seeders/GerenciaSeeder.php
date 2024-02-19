<?php

namespace Database\Seeders;

use App\Models\Gerencias;
use Illuminate\Database\Seeder;

class GerenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $gerencias = ['GERENCIA GENERAL', 'GERENCIA ADMINISTRATIVA', 'GERENCIA COMERCIAL', 'GERENCIA TECNICA'];
        foreach($gerencias as $gerencia){
            Gerencias::create([
                'nombre_gerencia' => $gerencia
            ]);
        }
    }
}
