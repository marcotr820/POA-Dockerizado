<?php

namespace Database\Seeders;

use App\Models\Partidas;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PartidaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // si la tabla tiene hijos que tengan su llave foranea no se debe usar truncate 
        // Partidas::truncate();
  
        $csvFile = fopen(base_path("database/data/partidas.csv"), "r");
        $firstline = false;
        while (($data = fgetcsv($csvFile, 2000, ";")) !== FALSE) {
            if (!$firstline) {
                Partidas::create([
                    "codigo_partida" => $data['1'],
                    "nombre_partida" => $data['2'],
                    "tipo_partida" => $data['3']
                ]);    
            }
            $firstline = false;
        }
        fclose($csvFile);

        // Partidas::factory(3)->create();
    }
}
