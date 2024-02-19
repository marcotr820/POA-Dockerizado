<?php

namespace App\Http\Controllers;

use App\Http\Requests\CortoPlazoAccionRequest;
use App\Models\CortoPlazoAcciones;
use App\Models\PeiObjetivosEspecificos;
use App\Models\Pilares;
use App\Models\Planificaciones;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\DataTables;

class CortoPlazoAccionController extends Controller
{
    public function planificacion_evaluacion(Request $request)
    {
        // return CortoPlazoAcciones::where('trabajador_id', auth('usuario')->user()->trabajador->id)
        // ->where('status', 'aprobado')->select('corto_plazo_acciones.*')->orderBy('id')
        // ->addSelect(['count_planificacion' => Planificaciones::selectRaw('COUNT(*)')->whereColumn('corto_plazo_accion_id', 'corto_plazo_acciones.id')])
        // ->get();

        // if($request->ajax())
        // {
        //     $date = Carbon::now()->addYear();
        //     $pilares = Pilares::select('gestion_pilar')->groupBy('gestion_pilar')->orderBy('gestion_pilar', 'ASC')->get();

        //     if ($pilares->count()) {
        //         // si existe un pilar para la gestion siguiente se buscara los pilares con la gestion siguiente, si no se mostrara los pilares de la ultima gestion creada
        //         if ($pilares->last()->gestion_pilar == $date->year) {
        //             $gestion = $date->year;
        //         }else{
        //             $gestion = $pilares->last()->gestion_pilar;
        //         }
        //     }

        //     if (isset($gestion)){
        //         $corto_plazo_acciones = CortoPlazoAcciones::join('trabajadores', 'trabajadores.id', '=', 'corto_plazo_acciones.trabajador_id')
        //         ->join('unidades', 'unidades.id', '=', 'trabajadores.unidad_id')
        //         ->join('pei_objetivos_especificos', 'pei_objetivos_especificos.id', '=', 'corto_plazo_acciones.pei_objetivo_especifico_id')
        //         ->join('mediano_plazo_acciones', 'mediano_plazo_acciones.id', '=', 'pei_objetivos_especificos.mediano_plazo_accion_id')
        //         ->join('resultados', 'resultados.id', 'mediano_plazo_acciones.resultado_id')
        //         ->join('metas', 'metas.id', '=', 'resultados.meta_id')
        //         ->join('pilares', 'pilares.id', '=', 'metas.pilar_id')
        //         ->select('corto_plazo_acciones.*')
        //         ->where('pilares.gestion_pilar', $gestion)
        //         ->where('unidades.id', auth('usuario')->user()->trabajador->unidad->id)
        //         ->where('corto_plazo_acciones.status', 'aprobado')
        //         ->addSelect(['count_planificacion' => Planificaciones::selectRaw('COUNT(*)')->whereColumn('corto_plazo_accion_id', 'corto_plazo_acciones.id')]);
        //     } else {
        //         $corto_plazo_acciones = [];
        //     }

        //     return datatables($corto_plazo_acciones)->make(true);
            
        //     // return datatables()
        //     //     ->eloquent($corto_plazo_acciones)
        //     //     // ->addColumn('btn_planificacion_evaluacion', 'corto_plazo_acciones.btn_planificacion_evaluacion')
        //     //     // ->rawColumns(['btn_planificacion_evaluacion'])
        //     //     ->toJson();
        // }

        // return view('corto_plazo_acciones.lista_planificacion_evaluacion');
    }

    public function index(Request $request, PeiObjetivosEspecificos $pei_objetivo_especifico)
    {
        if($request->ajax())
        {
            $acciones_corto_plazo = CortoPlazoAcciones::where('pei_objetivo_especifico_id', $pei_objetivo_especifico->id)
                ->select('corto_plazo_acciones.*')
                ->orderBy('id', 'asc')
                ->where('trabajador_id', Auth::guard('usuario')->user()->trabajador->id);

            return DataTables::of($acciones_corto_plazo) //de la consulta usamos el $status para usarlo en la vista de los botones
                ->addColumn('planificacion', function (CortoPlazoAcciones $corto_plazo_accion){
                    return $corto_plazo_accion->planificacion()->count();
                })
                // contamos las evaluaciones que se tenga
                ->addColumn('evaluaciones', function(CortoPlazoAcciones $corto_plazo_accion){
                    return $corto_plazo_accion->evaluaciones()->count();
                })
                // ->rawColumns(['btn_corto_plazo'])
                ->toJson();
        }
        $data = CortoPlazoAcciones::query()->get();
        return view('corto_plazo_acciones.index', compact('data', 'pei_objetivo_especifico'));
    }

    public function store(CortoPlazoAccionRequest $request, PeiObjetivosEspecificos $pei_objetivo_especifico)
    {
        $carbon_fecha_inicio = Carbon::parse($request->fecha_inicio);
        $carbon_fecha_fin = Carbon::parse($request->fecha_fin);
        if($carbon_fecha_inicio->month <= $carbon_fecha_fin->month){ //retornamos error en la condicion para registrar
            CortoPlazoAcciones::create([
                'gestion' => $request->gestion,
                'accion_corto_plazo' => Str::upper($request->accion_corto_plazo),
                'resultado_esperado' => $request->resultado_esperado,
                'presupuesto_programado' => $request->presupuesto_programado,
                'fecha_inicio' => $request->fecha_inicio,
                'fecha_fin' => $request->fecha_fin,
                'trabajador_id' => Auth::guard('usuario')->user()->trabajador->id,
                'pei_objetivo_especifico_id' => $pei_objetivo_especifico->id
            ]);
        }
        else{
            throw ValidationException::withMessages([
                'fechas' => ['La fecha inicio no puede ser mayor que la fecha final']
            ]);
        }
          
    }

    public function update(CortoPlazoAccionRequest $request, CortoPlazoAcciones $corto_plazo_accion)
    {
        $nuevo_presupuesto = $request->presupuesto_programado;
        $total_ejecutado = $corto_plazo_accion->evaluaciones->sum('presupuesto_ejecutado');
        if($nuevo_presupuesto < $total_ejecutado)
        {
            throw ValidationException::withMessages(["presupuesto_programado" => "No se puede asignar un presupuesto menor a $total_ejecutado Bs."]);
        }

        $corto_plazo_accion->update([
            'gestion' => $request->gestion,
            'accion_corto_plazo' => Str::upper($request->accion_corto_plazo),
            'resultado_esperado' => $request->resultado_esperado,
            'presupuesto_programado' => $request->presupuesto_programado,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'status' => 'presentado'
        ]);
    }

    public function destroy(CortoPlazoAcciones $corto_plazo_accion)
    {
        $corto_plazo_accion->delete();
    }

}
