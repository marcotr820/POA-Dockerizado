<?php

namespace App\Http\Controllers;

use App\Models\Actividades;
use App\Models\CortoPlazoAcciones;
use Illuminate\Support\Facades\Auth;
use App\Models\Gerencias;
use App\Models\Pilares;
use App\Models\Trabajadores;
use App\Models\Unidades;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PoaController extends Controller
{
    public function __construct()
    {
        // $this->middleware(['role:TRABAJADOR']);
    }

    public function index(Request $request)
    {
        // si el trabajador no tiene su tado poa en 1 lanzara error 403
        abort_if(auth('usuario')->user()->trabajador->poa_status != 1, 403);

        $date = Carbon::now()->addYear();
        $pilares = Pilares::select('gestion_pilar')
            ->groupBy('gestion_pilar')
            ->orderBy('gestion_pilar', 'ASC')
            ->get();
        
        if ($pilares->count()) {
            // si existe un pilar para la gestion siguiente se buscara los pilares con la gestion siguiente
            // si no se mostrara los pilares de la ultima gestion creada
            if ($pilares->last()->gestion_pilar == $date->year) {
                $gestion = $date->year;
            }else{
                $gestion = $pilares->last()->gestion_pilar;
            }
        }
        
        if ($request->ajax()) {
            if (isset($gestion)) {
                $pei_objetivos = Gerencias::join('pei_objetivos_especificos', 'gerencias.id', '=', 'pei_objetivos_especificos.gerencia_id')
                    ->join('mediano_plazo_acciones', 'mediano_plazo_acciones.id', '=', 'pei_objetivos_especificos.mediano_plazo_accion_id')
                    ->join('resultados', 'resultados.id', '=', 'mediano_plazo_acciones.resultado_id')
                    ->join('metas', 'metas.id', '=', 'resultados.meta_id')
                    ->join('pilares', 'pilares.id', '=', 'metas.pilar_id')
                    ->select('gerencias.nombre_gerencia', 'pei_objetivos_especificos.*')
                    ->where('gerencias.id', Auth::guard('usuario')->user()->trabajador->unidad->gerencia->id)
                    // lista del objetivo especifico asignado a cada unidad para la siguiente gestion
                    ->where('pilares.gestion_pilar', $gestion)
                ;
            } else {
                $pei_objetivos = [];
            }

            return datatables($pei_objetivos)->make(true);
        }

        return view('poa.index');
    }

    public function ver_poas()
    {
        return view('poa.ver_poas');
    }

    public function obtener_unidades(Gerencias $gerencia)
    {
        return Unidades::where('gerencia_id', $gerencia->id)->get();
    }

    public function actividades_accion_corto_plazo(CortoPlazoAcciones $accion_corto_plazo)
    {
        return view('poa.actividades_accion_corto_plazo', compact('accion_corto_plazo'));
    }

    public function items_actividad(Actividades $actividad)
    {
        return view('poa.items_actividad', compact('actividad'));
    }

    public function tareas_especificas_actividad(Actividades $actividad)
    {
        return view('poa.tareas_especificas_actividad', compact('actividad'));
    }

    public function poas_gerencia(){
        $gerencias = Gerencias::get();

        // $date = Carbon::now()->addYear();
        // $pilares = Pilares::select('gestion_pilar')->groupBy('gestion_pilar')->orderBy('gestion_pilar', 'ASC')->get();
        // if ($pilares->count()) {
        //     // si existe un pilar para la gestion siguiente se buscara los pilares con la gestion siguiente, si no se mostrara los pilares de la ultima gestion creada
        //     if ($pilares->last()->gestion_pilar == $date->year) {
        //         $gestion = $date->year;
        //     }else{
        //         $gestion = $pilares->last()->gestion_pilar;
        //     }
        // }
        // if (isset($gestion)){
        //     return Unidades::where('gerencia_id', 1)
        //         ->addSelect(['suma_presupuesto_acciones' => CortoPlazoAcciones::selectRaw('SUM(presupuesto_programado)')
        //         ->join('trabajadores', 'trabajadores.id', '=', 'corto_plazo_acciones.trabajador_id')
        //         ->join('pei_objetivos_especificos', 'pei_objetivos_especificos.id', '=', 'corto_plazo_acciones.pei_objetivo_especifico_id')
        //         ->join('mediano_plazo_acciones', 'mediano_plazo_acciones.id', '=', 'pei_objetivos_especificos.mediano_plazo_accion_id')
        //         ->join('resultados', 'resultados.id', 'mediano_plazo_acciones.resultado_id')
        //         ->join('metas', 'metas.id', '=', 'resultados.meta_id')
        //         ->join('pilares', 'pilares.id', '=', 'metas.pilar_id')
        //         ->whereColumn('trabajadores.unidad_id', 'unidades.id')
        //         ->where('pilares.gestion_pilar', $gestion)
        //         ])
        //     ->get();
        // } else {
        //     return [];
        // }

        // return Unidades::where('gerencia_id', 1)
        //     ->addSelect(['suma_presupuesto_acciones' => CortoPlazoAcciones::selectRaw('SUM(presupuesto_programado)')
        //     ->join('trabajadores', 'trabajadores.id', '=', 'corto_plazo_acciones.trabajador_id')
        //     ->join('pei_objetivos_especificos', 'pei_objetivos_especificos.id', '=', 'corto_plazo_acciones.pei_objetivo_especifico_id')
        //     ->join('mediano_plazo_acciones', 'mediano_plazo_acciones.id', '=', 'pei_objetivos_especificos.mediano_plazo_accion_id')
        //     ->join('resultados', 'resultados.id', 'mediano_plazo_acciones.resultado_id')
        //     ->join('metas', 'metas.id', '=', 'resultados.meta_id')
        //     ->join('pilares', 'pilares.id', '=', 'metas.pilar_id')
        //     ->whereColumn('trabajadores.unidad_id', 'unidades.id')
        //     ->where('pilares.gestion_pilar', 2023)
        //     ])
        // ->get();

        return view('poa.poas_gerencia', compact('gerencias'));
    }

    public function get_poas_gerencia(Gerencias $gerencia)
    {
        $date = Carbon::now()->addYear();
        $pilares = Pilares::select('gestion_pilar')->groupBy('gestion_pilar')->orderBy('gestion_pilar', 'ASC')->get();
        if ($pilares->count()) {
            // si existe un pilar para la gestion siguiente se buscara los pilares con la gestion siguiente, si no se mostrara los pilares de la ultima gestion creada
            if ($pilares->last()->gestion_pilar == $date->year) {
                $gestion = $date->year;
            }else{
                $gestion = $pilares->last()->gestion_pilar;
            }
        }
        if (isset($gestion)){
            $query = Unidades::query()->where('gerencia_id', $gerencia->id)
                ->addSelect(['suma_presupuesto_acciones' => CortoPlazoAcciones::selectRaw('SUM(presupuesto_programado)')
                ->join('trabajadores', 'trabajadores.id', '=', 'corto_plazo_acciones.trabajador_id')
                ->join('pei_objetivos_especificos', 'pei_objetivos_especificos.id', '=', 'corto_plazo_acciones.pei_objetivo_especifico_id')
                ->join('mediano_plazo_acciones', 'mediano_plazo_acciones.id', '=', 'pei_objetivos_especificos.mediano_plazo_accion_id')
                ->join('resultados', 'resultados.id', 'mediano_plazo_acciones.resultado_id')
                ->join('metas', 'metas.id', '=', 'resultados.meta_id')
                ->join('pilares', 'pilares.id', '=', 'metas.pilar_id')
                ->whereColumn('trabajadores.unidad_id', 'unidades.id')
                ->where('pilares.gestion_pilar', $gestion)
            ]);
            // ->get();

            $total_presupuesto_programado = $query->get()->sum('suma_presupuesto_acciones');

            return datatables($query)
                ->with('total_programado', number_format($total_presupuesto_programado, 2, '.', ','))
                ->make(true);
        } else {
            return datatables([])->make(true);
        }
    }

    public function acciones_unidad(Unidades $unidad)
    {
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

        if (isset($gestion)) {
            $corto_plazo_acciones = CortoPlazoAcciones::join('trabajadores', 'trabajadores.id', '=', 'corto_plazo_acciones.trabajador_id')
            ->join('unidades', 'unidades.id', '=', 'trabajadores.unidad_id')
            ->join('pei_objetivos_especificos', 'pei_objetivos_especificos.id', '=', 'corto_plazo_acciones.pei_objetivo_especifico_id')
            ->join('mediano_plazo_acciones', 'mediano_plazo_acciones.id', '=', 'pei_objetivos_especificos.mediano_plazo_accion_id')
            ->join('resultados', 'resultados.id', 'mediano_plazo_acciones.resultado_id')
            ->join('metas', 'metas.id', '=', 'resultados.meta_id')
            ->join('pilares', 'pilares.id', '=', 'metas.pilar_id')
            ->select('corto_plazo_acciones.*')
            ->where('pilares.gestion_pilar', $gestion)
            ->where('unidades.id', $unidad->id)
            ->get();
        } else {
            $corto_plazo_acciones = [];
        }
        
        return view('poa.acciones_unidad_gerencia', compact('unidad', 'corto_plazo_acciones'));
    }
}
