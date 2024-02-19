<?php

namespace App\Http\Controllers;

use App\Http\Requests\MedianoPlazoAccionRequest;
use App\Models\MedianoPlazoAcciones;
use App\Models\Resultados;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class MedianoPlazoAccionController extends Controller
{
    public function index(Request $request, Resultados $resultado)
    {
        if($request->ajax())
        {
            $mediano_plazo_acciones = MedianoPlazoAcciones::join('resultados', 'resultados.id', '=', 'mediano_plazo_acciones.resultado_id')
                  ->select('mediano_plazo_acciones.id', 'mediano_plazo_acciones.codigo_mediano_plazo', 'mediano_plazo_acciones.accion_mediano_plazo', 'mediano_plazo_acciones.uuid')
                    ->where('mediano_plazo_acciones.resultado_id', $resultado->id);

            return datatables()
            ->eloquent($mediano_plazo_acciones)
            ->toJson();
            
        }
        return view('mediano_plazo_acciones.index', compact('resultado'));
    }

    public function store(MedianoPlazoAccionRequest $request, Resultados $resultado)
    {
        MedianoPlazoAcciones::create([
            'codigo_mediano_plazo' => $request->codigo_mediano_plazo,
            'accion_mediano_plazo' => str::upper($request->accion_mediano_plazo),
            'resultado_id' => $resultado->id
        ]);
    }

    public function update(MedianoPlazoAccionRequest $request, MedianoPlazoAcciones $mediano_plazo_accion)
    {
        $mediano_plazo_accion->update([
            'codigo_mediano_plazo' => $request->codigo_mediano_plazo,
            'accion_mediano_plazo' => str::upper($request->accion_mediano_plazo),
        ]);
    }

    public function destroy(MedianoPlazoAcciones $mediano_plazo_accion)
    {
        $mediano_plazo_accion->delete();
    }
}
