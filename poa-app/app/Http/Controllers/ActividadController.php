<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActividadRequest;
use App\Models\Actividades;
use App\Models\CortoPlazoAcciones;
use App\Models\Operaciones;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ActividadController extends Controller
{
    public function index(Request $request, Operaciones $operacion)
    {
        if($request->ajax())
        {
            $actividades = Actividades::where('operacion_id', $operacion->id);
            return datatables($actividades)
                ->addColumn('items_presupuesto', function (Actividades $actividades){
                    return $actividades->items()->sum('presupuesto');
                })
                ->addColumn('status_accion_corto_plazo', function($actividades){
                    return $actividades->operacion->corto_plazo_accion->status;
                })
                ->make(true);
        }
        // $operacion = Operaciones::findOrFail($operacion_id);
        return view('actividades.index', compact('operacion'));
    }

    public function store(ActividadRequest $request, Operaciones $operacion)
    {
        Actividades::create([
            'nombre_actividad' => Str::upper($request->nombre_actividad),
            'resultado_esperado' => Str::upper($request->resultado_esperado),
            'operacion_id' => $operacion->id
        ]);
    }

    public function update(ActividadRequest $request, Actividades $actividad)
    {
        // $actividad->update($request->only(['nombre_actividad', 'resultado_esperado']));
        $actividad->update([
            'nombre_actividad' => Str::upper($request->nombre_actividad),
            'resultado_esperado' =>Str::upper($request->resultado_esperado)
        ]);
        // return $request->all();
    }

    public function destroy(Actividades $actividad)
    {
        $actividad->delete();
    }
}
