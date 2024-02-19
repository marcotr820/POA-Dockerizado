<?php

namespace App\Http\Controllers;

use App\Http\Requests\PilarRequest;
use App\Models\Pilares;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PilarController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:PLANIFICADOR']);
    }

    public function index(Request $request){
        $date = Carbon::now()->addYear();
        $pilares = Pilares::select('gestion_pilar')
            ->groupBy('gestion_pilar')
            ->orderBy('gestion_pilar', 'ASC')
            ->get();

        if ($pilares->count()) {
            // si existe un pilar para la gestion siguiente se buscara los pilares con la gestion siguiente, si no se mostrara los pilares de la ultima gestion creada
            if ($pilares->last()->gestion_pilar == $date->year) {
                $gestion = $date->year;
            }else{
                $gestion = $pilares->last()->gestion_pilar;
            }
        }
        
        if($request->ajax())
        {
            if (isset($gestion)) {
               //  $query = Pilares::query()->select('id', 'codigo_pilar', 'nombre_pilar', 'gestion_pilar', 'uuid') // mostrar solo los pilares para la siguiente gestion
               $query = Pilares::query()->select('id', 'nombre_pilar', 'gestion_pilar', 'uuid', "codigo_pilar") 
               ->where('gestion_pilar', $gestion);
            } else {
                $query = [];
            }
                
            return datatables($query)->make(true);
        }
        return view('pilares.index');
    }

    public function store(PilarRequest $request)
    {
      Pilares::create([
        'codigo_pilar' => str::upper($request->codigo_pilar),
        'nombre_pilar' => str::upper($request->nombre_pilar),
        'gestion_pilar' => $request->gestion_pilar
      ]); 
    }

    public function update(PilarRequest $request, Pilares $pilar)
    {
        // $pilar->update($request->only(['nombre_pilar', 'gestion_pilar']));
        $pilar->update([
            'codigo_pilar' => $request->codigo_pilar,
            'nombre_pilar' => str::upper($request->nombre_pilar),
            'gestion_pilar' => $request->gestion_pilar,
        ]);
    }

    public function destroy(Pilares $pilar)
    {
        $pilar->delete();
    }
}
