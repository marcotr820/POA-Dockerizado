<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemRequest;
use App\Models\Actividades;
use App\Models\CortoPlazoAcciones;
use App\Models\Items;
use App\Models\Partidas;
USE Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ItemController extends Controller
{
    public function index(Request $request, Actividades $actividad)
    {
        if($request->ajax())
        {
            $items = Items::with('partida')->where('actividad_id', $actividad->id);

            return datatables($items)
                ->addColumn('status_accion_corto_plazo', function($items){
                    return $items->actividad->operacion->corto_plazo_accion->status;
                })
                ->make(true);
        }
        // $partidas = Partidas::pluck('nombre_partida', 'id');
        $partidas = Partidas::select('id', 'codigo_partida', 'nombre_partida')->get();
        $accion = $actividad->operacion->corto_plazo_accion;
        return view('items.index', compact('actividad', 'partidas', 'accion'));
    }

    public function store(ItemRequest $request, Actividades $actividad)
    {
        $inicio = $actividad->operacion->corto_plazo_accion->fecha_inicio;
        $fin = $actividad->operacion->corto_plazo_accion->fecha_fin;

        // verificacion item no salga de los rangos fecha de la accion corto plazo
        if(! ( strtotime($request->fecha_requerida) >= strtotime($inicio) && strtotime($request->fecha_requerida) <= strtotime($fin) )){
            throw ValidationException::withMessages(['fecha_requerida' => "rangos validos entre $inicio hasta $fin"]);
        }

        // verificacion que no se sobrepase el presupuesto asignado
        $presupuesto_programado = $actividad->operacion->corto_plazo_accion->presupuesto_programado;
        $presupuesto_ejecutado = $actividad->operacion->corto_plazo_accion->items->sum('presupuesto') + $request->presupuesto;
        $restante = $presupuesto_programado - $actividad->operacion->corto_plazo_accion->items->sum('presupuesto');
        if($presupuesto_ejecutado > $presupuesto_programado){
            throw ValidationException::withMessages(['presupuesto' => "Su presupuesto restante es de $restante Bs."]);
        }
        
        Items::create([
            'bien_servicio' => Str::upper($request->bien_servicio),
            'fecha_requerida' => $request->fecha_requerida,
            'presupuesto' => $request->presupuesto,
            'partida_id' => $request->partida_id,
            'actividad_id' => $actividad->id
        ]);
    }

    public function update(ItemRequest $request, Items $item)
    {
        $corto_plazo_accion = CortoPlazoAcciones::join('operaciones', 'operaciones.corto_plazo_accion_id', '=', 'corto_plazo_acciones.id')
            ->join('actividades', 'actividades.operacion_id', '=', 'operaciones.id')
            ->join('items', 'items.actividad_id', '=', 'actividades.id')
            ->select('corto_plazo_acciones.*')
            ->where('actividades.id', $item->actividad_id)->first();

        $old_presupuesto_item = intval($item->presupuesto);
        
        $presupuesto_accion = $corto_plazo_accion->presupuesto_programado;
        //ejecutado suma de todos los presupuestos menos el que se editara para obtener el presupuesto actual ejecutado
        $ejecutado = $corto_plazo_accion->items->sum('presupuesto') - $old_presupuesto_item;
        // presupuesto restante al momento de editar añadiendo el monto del item que se esta editando para obtener el restante actual
        $restante = $presupuesto_accion - $corto_plazo_accion->items->sum('presupuesto') + $old_presupuesto_item;

        if(($ejecutado + $request->presupuesto) > $presupuesto_accion){
            throw ValidationException::withMessages(['presupuesto' => "su presupuesto restante es de $restante Bs."]);
        }

        $item->update([
            'bien_servicio' => Str::upper($request->bien_servicio),
            'fecha_requerida' => $request->fecha_requerida,
            'presupuesto' => $request->presupuesto,
            'partida_id' => $request->partida_id
        ]);
    }

    public function destroy(Items $item)
    {
        $item->delete();
    }
}
