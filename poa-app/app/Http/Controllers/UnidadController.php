<?php

namespace App\Http\Controllers;

use App\Http\Requests\UnidadRequest;
use App\Models\Gerencias;
use App\Models\Unidades;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class UnidadController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:ADMIN']);
    }

    public function index(Request $request){
        if($request->ajax())
        {
            $query = Unidades::join("gerencias", "gerencias.id", "=", "unidades.gerencia_id")
                ->select("unidades.id", "unidades.nombre_unidad", "unidades.gerencia_id", "unidades.uuid", "gerencias.nombre_gerencia")
                ->orderBy('id', 'asc');
            return datatables($query)->make(true);
            // return datatables()
            //     ->eloquent($unidades)
            //     ->toJson();
        }
        
        $gerencias = Gerencias::select('id', 'nombre_gerencia')->get();
        return view('unidades.index', compact('gerencias'));
    }

    public function store(UnidadRequest $request)
    {
        Unidades::create([
            'nombre_unidad' => Str::upper($request->nombre_unidad),
            'gerencia_id' => $request->gerencia_id,
        ]);
    }

    public function update(UnidadRequest $request, Unidades $unidad)
    {
        $unidad->update([
            'nombre_unidad' => Str::upper($request->nombre_unidad),
            'gerencia_id' => $request->gerencia_id,
        ]);
    }

    public function destroy(Unidades $unidad)
    {
        $unidad->delete();
    }
}
