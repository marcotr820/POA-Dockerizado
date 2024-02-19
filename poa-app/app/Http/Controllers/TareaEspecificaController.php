<?php

namespace App\Http\Controllers;

use App\Models\Actividades;
use App\Models\TareasEspecificas;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class TareaEspecificaController extends Controller
{
    public function index(Request $request, Actividades $actividad)
    {
        if($request->ajax())
        {
            $tareas_especificas = TareasEspecificas::where('actividad_id', $actividad->id);
            return datatables($tareas_especificas)
                ->addColumn('status_accion_corto_plazo', function($tareas_especificas){
                    return $tareas_especificas->actividad->operacion->corto_plazo_accion->status;
                })
                ->make(true);
        }
        return view('tareas_especificas.index', compact('actividad'));
    }

    public function store(Request $request, Actividades $actividad)
    {
        $request->validate([
            'nombre_tarea' => 'required',
        ]);

        TareasEspecificas::create([
            'nombre_tarea' => Str::upper($request->nombre_tarea),
            'actividad_id' => $actividad->id
        ]);
    }

    public function update(Request $request, TareasEspecificas $tarea_especifica)
    {
        $request->validate([
            'nombre_tarea' => 'required',
        ]);
        $tarea_especifica->update([
            'nombre_tarea' => Str::upper($request->nombre_tarea),
        ]);
    }

    public function destroy(TareasEspecificas $tarea_especifica)
    {
        $tarea_especifica->delete();
    }
}
