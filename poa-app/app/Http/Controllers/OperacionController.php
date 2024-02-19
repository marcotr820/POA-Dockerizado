<?php

namespace App\Http\Controllers;

use App\Http\Requests\OperacionRequest;
use App\Models\Actividades;
use App\Models\CortoPlazoAcciones;
use App\Models\Operaciones;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class OperacionController extends Controller
{
    public function index(Request $request, CortoPlazoAcciones $corto_plazo_accion)
    {
        // return $corto_plazo_accion->actividades()->where('actividades.id', 2)->get();
        // return $corto_plazo_accion->actividades()->where('actividades.resultado_esperado', 22)->get();
        // *load* devuelve la coleccion del registro especificado // *with* devuelve todos los registros con sus colecciones
        // return $corto_plazo_accion->load('operaciones.actividades');

        // return $corto_plazo_accion->load(['operaciones' => function ($query){
        //     $query->where('id', 6);
        // }]);

        if($request->ajax())
        {
            $operaciones = Operaciones::with('corto_plazo_accion')->where('corto_plazo_accion_id', $corto_plazo_accion->id);
            return datatables($operaciones)
                // ->addColumn('status', function($operaciones){
                //     return $operaciones->corto_plazo_accion->status;
                // })
                // ->eloquent($operaciones)
                ->toJson();
        }
        return view('operaciones.index', compact('corto_plazo_accion'));
    }

    public function store(OperacionRequest $request, CortoPlazoAcciones $corto_plazo_accion)
    {
        Operaciones::create([
            'nombre_operacion' => Str::upper($request->nombre_operacion),
            'corto_plazo_accion_id' => $corto_plazo_accion->id
        ]);
    }

    public function update(OperacionRequest $request, Operaciones $operacion)
    {
        // $operacion->update($request->only(['nombre_operacion']));
        $operacion->update([
            'nombre_operacion' => Str::upper($request->nombre_operacion)
        ]);
    }

    public function destroy(Operaciones $operacion)
    {
        $operacion->delete();
    }
}
