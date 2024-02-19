<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResultadoRequest;
use App\Models\Metas;
use App\Models\Resultados;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

use function GuzzleHttp\Promise\all;

class ResultadoController extends Controller
{
    public function index(Request $request, Metas $meta)
    {
        if($request->ajax())
        {
            $resultados = Resultados::join("metas", "metas.id", "=", "resultados.meta_id")
                    ->select("resultados.id", "resultados.codigo_resultado", 'resultados.nombre_resultado', 'resultados.uuid')
                    ->where('resultados.meta_id', $meta->id);

            return datatables()
                ->eloquent($resultados)
                ->toJson();
        }
        // return view('resultados.index')->with('meta_id', $meta_id);
        return view('resultados.index', compact('meta'));
    }

    public function store(ResultadoRequest $request, Metas $meta)
    {
        Resultados::create([
            'codigo_resultado' => $request->codigo_resultado,
            'nombre_resultado' => str::upper($request->nombre_resultado),
            'meta_id' => $meta->id
        ]);
    }

    public function update(ResultadoRequest $request, Resultados $resultado)
    {
        $resultado->update([
            'codigo_resultado' => $request->codigo_resultado,
            'nombre_resultado' => str::upper($request->nombre_resultado),
        ]);
    }

    public function destroy(Resultados $resultado)
    {
        $resultado->delete();
    }
}
