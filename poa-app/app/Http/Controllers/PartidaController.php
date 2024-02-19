<?php

namespace App\Http\Controllers;

use App\Http\Requests\PartidaRequest;
use App\Models\Gerencias;
use App\Models\Partidas;
use App\Models\Pilares;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PartidaController extends Controller
{
    public function __construct(){
        // solo los usuarios con los permisos especificados podran ingresar a los metodos
        $this->middleware(['role:PLANIFICADOR']);
        $this->middleware(['permission:VER-DIRECTRIZ|edit-articles']);
    }

    public function index(Request $request)
    {
        // return Partidas::with(["items" => function($q){
        //     $q->select('items.*')
        //     ->join('actividades', 'actividades.id', '=', 'items.actividad_id')
        //     ->join('operaciones', 'operaciones.id', '=', 'actividades.operacion_id')
        //     ->join('corto_plazo_acciones', 'corto_plazo_acciones.id', '=', 'operaciones.corto_plazo_accion_id')
        //     ->join('pei_objetivos_especificos', 'pei_objetivos_especificos.id', '=', 'corto_plazo_acciones.pei_objetivo_especifico_id')
        //     ->join('mediano_plazo_acciones', 'mediano_plazo_acciones.id', '=', 'pei_objetivos_especificos.mediano_plazo_accion_id')
        //     ->join('resultados', 'resultados.id', '=', 'mediano_plazo_acciones.resultado_id')
        //     ->join('metas', 'metas.id', '=', 'resultados.meta_id')
        //     ->join('pilares', 'pilares.id', '=', 'metas.pilar_id')
        //     ->where('pilares.gestion_pilar', 2023);
        // }])->get();

        // $array = [];
        // $partidas = Partidas::get();
        // $i = 0;
        // $last_id = $partidas->last()->id; 
        // foreach ($partidas as $p) {
        //     if( $i != substr($p->codigo_partida, 0,1) )
        //     {
        //         if (isset($grupo)) {
        //             array_push($array, $grupo);
        //         }
        //         $grupo = [];
        //         $i++;
        //     }

        //     if( $i == substr($p->codigo_partida, 0,1) ){
        //         array_push($grupo, $p);
        //     }

        //     if( $p->id == $last_id ){
        //         array_push($array, $grupo);
        //     }
        // }
        // // return $array[0][0]->items->sum('presupuesto');
        // return $array;
        
        // return Str::random(23).round(microtime(true) * 1000);
        if($request->ajax())
        {
            $query = Partidas::select('id', 'codigo_partida', 'nombre_partida', 'tipo_partida', 'uuid')->orderBy('id');
            return datatables($query)->make(true);
            // return datatables()
            //     ->eloquent(Partidas::query())
            //     ->toJson();
        }
        return view('partidas.index');
    }

    public function store(PartidaRequest $request)
    {
        Partidas::create([
            'nombre_partida' => Str::upper($request->nombre_partida),
            'codigo_partida' => $request->codigo_partida,
            'tipo_partida' => Str::upper($request->tipo_partida)
        ]);
    }
    public function update(PartidaRequest $request, Partidas $partida)
    {
        $partida->update([
            'nombre_partida' => Str::upper($request->nombre_partida),
            'codigo_partida' => $request->codigo_partida,
            'tipo_partida' => Str::upper($request->tipo_partida)
        ]);
    }

    public function destroy(Partidas $partida)
    {
        $partida->delete();
    }

    public function partida_gestion()
    {
        $gerencias = Gerencias::get();
        $gestiones = Pilares::select('gestion_pilar')->groupBy('gestion_pilar')->orderBy('gestion_pilar', 'asc')->get();
        return view('partidas.reporte_por_gestion', compact('gestiones', 'gerencias'));
    }
}
