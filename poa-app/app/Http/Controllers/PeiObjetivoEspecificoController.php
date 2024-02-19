<?php
namespace App\Http\Controllers;

use App\Http\Requests\PeiObjetivoEspecificoRequest;
use App\Models\Gerencias;
use App\Models\MedianoPlazoAcciones;
use App\Models\PeiObjetivosEspecificos;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PeiObjetivoEspecificoController extends Controller
{
    public function index(Request $request, MedianoPlazoAcciones $mediano_plazo_accion)
    {
        // return Gerencias::where('id', 4)->with(['pei_objetivos_especificos' => function($q){
        //     $q->select('pei_objetivos_especificos.*')
        //     ->join('mediano_plazo_acciones', 'mediano_plazo_acciones.id', '=', 'pei_objetivos_especificos.mediano_plazo_accion_id')
        //     ->join('resultados', 'resultados.id', '=', 'mediano_plazo_acciones.resultado_id')
        //     ->join('metas', 'metas.id', '=', 'resultados.meta_id')
        //     ->join('pilares', 'pilares.id', '=', 'metas.pilar_id')
        //     ->where('pilares.gestion_pilar', 2023);
        // }])->first();

        if($request->ajax())
        {
            $data = Gerencias::join('pei_objetivos_especificos', 'gerencias.id', '=', 'pei_objetivos_especificos.gerencia_id')
                ->select(
                    'gerencias.nombre_gerencia', 'pei_objetivos_especificos.objetivo_institucional', 
                    'pei_objetivos_especificos.id', 'pei_objetivos_especificos.ponderacion', 
                    'pei_objetivos_especificos.indicador_proceso', 'pei_objetivos_especificos.uuid',
                    'pei_objetivos_especificos.gerencia_id'
                )
                ->where('pei_objetivos_especificos.mediano_plazo_accion_id', $mediano_plazo_accion->id);

            return datatables()
                ->eloquent($data)
                ->toJson();
        }
        $gerencias = Gerencias::query()->select('id', 'nombre_gerencia')->get();
        return view('pei_objetivos_especificos.index', compact('gerencias', 'mediano_plazo_accion'));
    }

    public function store(PeiObjetivoEspecificoRequest $request, MedianoPlazoAcciones $mediano_plazo_accion)
    {
        $gerencia = Gerencias::where('id', $request->gerencia_id)->with(['pei_objetivos_especificos' => function($q){
            $q->select('pei_objetivos_especificos.*')
            ->join('mediano_plazo_acciones', 'mediano_plazo_acciones.id', '=', 'pei_objetivos_especificos.mediano_plazo_accion_id')
            ->join('resultados', 'resultados.id', '=', 'mediano_plazo_acciones.resultado_id')
            ->join('metas', 'metas.id', '=', 'resultados.meta_id')
            ->join('pilares', 'pilares.id', '=', 'metas.pilar_id')
            ->where('pilares.gestion_pilar', 2023);
        }])->first();
        $sum = $gerencia->pei_objetivos_especificos->sum('ponderacion') + $request->ponderacion;
        $ponderacion_restante = 100 - $gerencia->pei_objetivos_especificos->sum('ponderacion');
        if ($sum > 100) {
            throw ValidationException::withMessages(['ponderacion' => "Ponderación restante $ponderacion_restante %"]);
        }
        PeiObjetivosEspecificos::create([
            'objetivo_institucional' => str::upper($request->objetivo_institucional),
            'ponderacion' => $request->ponderacion,
            'indicador_proceso' => str::upper($request->indicador_proceso),
            'gerencia_id' => $request->gerencia_id,
            'mediano_plazo_accion_id' => $mediano_plazo_accion->id
        ]);
    }

    public function update(PeiObjetivoEspecificoRequest $request, PeiObjetivosEspecificos $pei_objetivo_especifico)
    {
        $gerencia = Gerencias::where('id', $request->gerencia_id)->with(['pei_objetivos_especificos' => function($q){
            $q->select('pei_objetivos_especificos.*')
            ->join('mediano_plazo_acciones', 'mediano_plazo_acciones.id', '=', 'pei_objetivos_especificos.mediano_plazo_accion_id')
            ->join('resultados', 'resultados.id', '=', 'mediano_plazo_acciones.resultado_id')
            ->join('metas', 'metas.id', '=', 'resultados.meta_id')
            ->join('pilares', 'pilares.id', '=', 'metas.pilar_id')
            ->where('pilares.gestion_pilar', 2023);
        }])->first();
        $ponderacion_actual = $gerencia->pei_objetivos_especificos->sum('ponderacion') - $pei_objetivo_especifico->ponderacion;
        $sum = $ponderacion_actual + $request->ponderacion;
        $ponderacion_restante = 100 - $ponderacion_actual;
        if ($sum > 100) {
            throw ValidationException::withMessages(['ponderacion' => "Ponderacion restate $ponderacion_restante %"]);
        }
        
        $pei_objetivo_especifico->update([
            'objetivo_institucional' => str::upper($request->objetivo_institucional),
            'ponderacion' => $request->ponderacion,
            'indicador_proceso' => str::upper($request->indicador_proceso),
            'gerencia_id' => $request->gerencia_id
        ]);

    }

    public function destroy(PeiObjetivosEspecificos $pei_objetivo_especifico)
    {
        $pei_objetivo_especifico->delete();
    }
}
