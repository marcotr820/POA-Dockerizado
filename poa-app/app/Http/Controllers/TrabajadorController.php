<?php

namespace App\Http\Controllers;

use App\Http\Requests\TrabajadorRequest;
use App\Models\Gerencias;
use App\Models\Trabajadores;
use App\Models\Unidades;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class TrabajadorController extends Controller
{
    public function __construct(){
        // solo los usuarios con los permisos especificados podran ingresar a los metodos
        // $this->middleware(['permission:SUPER-ADMIN|edit-articles']);
    }

    public function index(Request $request){
        // return (string) Str::random(20).date('s');
        //obtenemos los datos pedidos de la peticion ajax
        if($request->ajax()){
            $query = Gerencias::join("unidades", "gerencias.id", "=", "unidades.gerencia_id")
                ->join('trabajadores', 'unidades.id', '=', 'trabajadores.unidad_id')
                ->select(
                    'trabajadores.id', 'trabajadores.documento', 'trabajadores.nombre', 'trabajadores.cargo',
                    'trabajadores.unidad_id', 'trabajadores.uuid',
                    'gerencias.nombre_gerencia', 'unidades.nombre_unidad'
                )->orderBy('id', 'asc');
            
            return datatables($query)->make(true);
            //retornamos los datos ajax formato json con la libreria yajra para poder convertirlo en JSON
            // return datatables()
            //     ->eloquent($query)
            //     // ->addColumn('btn_trabajadores', view('trabajadores.acciones_trabajador'))
            //     ->toJson();
        }

        //indicamos que nos obtenga los usuarios dondel el id del usuario no este en los datos de la tabla trabajadores en el campo usuario_id
        // $usuarios = Usuario::whereNotIn('id', Trabajadores::all('usuario_id'))->get();
        $unidades = Unidades::select('id', 'nombre_unidad')->get();
        return view('trabajadores.index', compact('unidades'));
    }

    public function store(TrabajadorRequest $request)
    {
        Trabajadores::create([
            'documento' => trim($request->documento),
            'nombre' => strtoupper(trim($request->nombre)),
            'cargo' => strtoupper(trim($request->cargo)),
            'unidad_id' => $request->unidad_id,
        ]);
    }

    public function update(TrabajadorRequest $request, Trabajadores $trabajador)
    {
        if($trabajador->id == 1){   //evitamos que se elimine el usuario con id 1 ADMINISTRADOR
            abort(200);
        }

        $trabajador->update([
            'documento' => $request->documento,
            'nombre' => strtoupper(trim($request->nombre)),
            'cargo' => strtoupper(trim($request->cargo)),
            'unidad_id' => $request->unidad_id
        ]);

        //$request->session()->forget('id_gerencia');
        //actualizamos el id de la gerencia para mostrar gerencia a la que pertenece un trabajador 
        // $gerencia = Trabajadores::join('unidades', 'unidades.id', '=', 'trabajadores.unidad_id')
        //                     ->join('gerencias', 'gerencias.id', '=', 'unidades.gerencia_id')
        //                     ->select('gerencias.id')
        //                     ->where('trabajadores.id', Auth::guard('trabajador')->user()->id)->first();

        // $request->session()->put('id_gerencia', $gerencia->id);
    }

    public function destroy(Trabajadores $trabajador)
    {
        if($trabajador->id == 1){   //evitamos que se elimine el usuario con id 1 ADMINISTRADOR
            abort(500);
        }
        $trabajador->delete();
    }
}
