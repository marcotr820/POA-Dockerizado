<?php

namespace App\Http\Controllers;
use App\Models\Actividades;
use App\Models\CortoPlazoAcciones;
use App\Models\Gerencias;
use App\Models\Items;
use App\Models\MedianoPlazoAcciones;
use App\Models\Metas;
use App\Models\Operaciones;
use App\Models\Partidas;
use App\Models\Pilares;
use App\Models\Planificaciones;
use App\Models\Resultados;
use App\Models\TareasEspecificas;
use App\Models\Trabajadores;
use App\Models\Unidades;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class DatatableController extends Controller
{
    // public function listarUsuario(Request $request)
    // {
    //     //obtenemos los datos pedidos
    //     if($request->ajax())
    //     {
    //         //$usuario = Usuario::join("trabajadores", "trabajadores.usuario_id", "=", "usuarios.id");
    //         $usuario = Usuario::query()
    //             ->select('id', 'usuario', 'password');

    //         //retornamos los datos ajax formato json con la libreria yajra para poder convertirlo en JSON
    //         return DataTables::of($usuario)//retornamos con una consulta eloquent los datos necesarios para armar la tabla
    //             ->addColumn('btn_usuarios', function(){
    //                 return view('usuarios.acciones_usuario');
    //             })
    //             //->rawColumns(['botones_usuarios']) indicamos que renderice todo menos la columna botones_usuarios si nos da codigo html
    //             ->toJson();
    //         //return $usuario;
    //     }
    // }

    // public function listarTrabajador(Request $request)
    // {

    //     //obtenemos los datos pedidos de la peticion ajax
    //     if($request->ajax())
    //     {
    //         $trabajadores = Gerencias::join("unidades", "gerencias.id", "=", "unidades.gerencia_id")
    //             ->join('trabajadores', 'unidades.id', '=', 'trabajadores.unidad_id');
    //         //retornamos los datos ajax formato json con la libreria yajra para poder convertirlo en JSON
    //         return datatables()
    //             ->eloquent($trabajadores)
    //             ->addColumn('btn_trabajadores', view('trabajadores.acciones_trabajador'))
    //             ->toJson();
    //     }
    // }

    public function select_usuario(){
        //indicamos que nos obtenga los usuarios dondel el id del usuario no este en los datos de la tabla trabajadores en el campo usuario_id
        return Usuario::query()
            ->whereNotIn('id', Trabajadores::query()->select('usuario_id'))
            ->select('usuarios.usuario')
            ->get();
    }

    // public function listarGerencia(Request $request)
    // {
    //     if($request->ajax())
    //     {
    //         return datatables()
    //             ->eloquent(Gerencias::query()
    //                 ->select('id', 'nombre_gerencia'))
    //             ->addColumn('btn_gerencia', view('gerencias.acciones_gerencia'))
    //             ->toJson();
    //     }
    // }

    // public function listarUnidad(Request $request){
    //     if($request->ajax())
    //     {
    //         $unidades = Unidades::join("gerencias", "gerencias.id", "=", "unidades.gerencia_id")->select("unidades.*", "gerencias.nombre_gerencia");
    //         return datatables()
    //             ->eloquent($unidades)
    //             ->addColumn('btn_unidades', view('unidades.acciones_unidad'))
    //             ->toJson();
    //     }
    // }

    // public function listarPilar(Request $request)
    // {
    //     if($request->ajax())
    //     {
    //         return datatables()
    //             ->eloquent(Pilares::query()->select('id', 'nombre_pilar', 'gestion_pilar'))
    //             ->addColumn('btn_pilares', view('pilares.acciones_pilar'))
    //             ->toJson();
    //     }
    // }

    // public function listarMeta(Request $request, $id_pilar){
    //     if($request->ajax())
    //     {
    //         $metas = Metas::join("pilares", "pilares.id", "=", "metas.pilar_id")
    //                 ->select("metas.id", "metas.nombre_meta")
    //                 ->where('metas.pilar_id', $id_pilar);

    //         return datatables()
    //             ->eloquent($metas)
    //             ->addColumn('btn_metas', view('metas.acciones_meta'))
    //             ->toJson();
    //     }
    // }

    // public function listarResultado(Request $request, $meta_id)
    // {
    //     if($request->ajax())
    //     {
    //         $resultados = Resultados::join("metas", "metas.id", "=", "resultados.meta_id")
    //                 ->select("resultados.id", 'resultados.nombre_resultado')
    //                 ->where('resultados.meta_id', $meta_id);

    //         return datatables()
    //             ->eloquent($resultados)
    //             ->addColumn('btn_resultados', view('resultados.acciones_resultado'))
    //             ->toJson();
    //     }
    // }

    // public function listarAccionesMedianoPlazo(Request $request, $resultado_id)
    // {
    //     if($request->ajax())
    //     {
    //         $mediano_plazo_acciones = MedianoPlazoAcciones::join('resultados', 'resultados.id', '=', 'mediano_plazo_acciones.resultado_id')
    //                 ->select('mediano_plazo_acciones.id', 'mediano_plazo_acciones.accion_mediano_plazo')
    //                 ->where('mediano_plazo_acciones.resultado_id', $resultado_id);

    //         return datatables()
    //         ->eloquent($mediano_plazo_acciones)
    //         ->addColumn('btn_mediano_plazo_acciones', view('mediano_plazo_acciones.acciones_mediano_plazo_accion'))
    //         ->toJson();
            
    //     }
    // }

    // public function listarPeiObjetivosEspecificos(Request $request, $accion_mediano_plazo_id)
    // {
    //     if($request->ajax())
    //     {
    //         //$pei_objetivos_especificos = PeiObjetivosEspecificos::where('accion_mediano_plazo_id', $accion_mediano_plazo_id);
    //         $data = Gerencias::join('pei_objetivos_especificos', 'gerencias.id', '=', 'pei_objetivos_especificos.gerencia_id')
    //             ->where('pei_objetivos_especificos.mediano_plazo_accion_id', $accion_mediano_plazo_id);

    //         return datatables()
    //             ->eloquent($data)
    //             ->addColumn('btn_objetivos_especificos', view('pei_objetivos_especificos.acciones_pei_objetivo_especifico'))
    //             ->toJson();
    //     }
    // }

    // public function listarPoas(Request $request)
    // {
    //     if($request->ajax())
    //     {
    //         $objetivos = Gerencias::join('pei_objetivos_especificos', 'gerencias.id', '=', 'pei_objetivos_especificos.gerencia_id')
    //             ->join('unidades', 'gerencias.id', '=', 'unidades.gerencia_id')
    //             ->select('gerencias.nombre_gerencia', 'pei_objetivos_especificos.*')
    //             // ->where('unidades.id', Auth::guard('trabajador')->user()->unidad_id);
    //             ->where('unidades.id', Auth::guard('usuario')->user()->trabajador->unidad_id);

    //         return datatables()
    //         ->eloquent($objetivos)
    //         ->addColumn('btn_poas', view('poa.acciones_poa'))
    //         ->toJson();
    //     }
    // }

    // public function estadoTrabajadores(Request $request)
    // {
    //     if($request->ajax())
    //     {

    //     $trabajadores = Trabajadores::join('unidades', 'unidades.id', '=', 'trabajadores.unidad_id')
    //                     ->join('gerencias', 'gerencias.id', '=', 'unidades.gerencia_id')
    //                     ->select('trabajadores.*', 'unidades.nombre_unidad', 'gerencias.nombre_gerencia');

    //     return datatables()
    //         ->eloquent($trabajadores)
    //         ->addColumn('btn_estado_trabajadores', view('estado_trabajadores.btn_estado_trabajadores'))
    //         ->toJson();

    //     }
    // }

    // public function listarCortoPlazoAcciones(Request $request, $pei_objetivo_especifico_id)
    // {
    //     if($request->ajax())
    //     {
    //         $acciones_corto_plazo = CortoPlazoAcciones::where('pei_objetivo_especifico_id', $pei_objetivo_especifico_id)
    //                 ->select('corto_plazo_acciones.*')
    //                 // ->where('trabajador_id', Auth::guard('trabajador')->user()->id);
    //                 ->where('trabajador_id', Auth::guard('usuario')->user()->trabajador->id);

    //         return Datatables::of($acciones_corto_plazo) //de la consulta usamos el status para usarlo en la vista de los botones
    //         ->addColumn('btn_corto_plazo', 'corto_plazo_acciones.btn_corto_plazo_accion')
    //         ->rawColumns(['btn_corto_plazo'])
    //         ->toJson();
    //     }
    // }

    //rescatamos el estado de la accion corto plazo para marcar los radio buttons
    // public function StatusCortoPlazoAccion($id_corto_plazo_accion)
    // {
    //     return CortoPlazoAcciones::select('status')->where('id', $id_corto_plazo_accion)->first();
    // }

    // public function listarOperaciones(Request $request, $corto_plazo_accion_id)
    // {
    //     if($request->ajax())
    //     {
    //         $operaciones = Operaciones::where('corto_plazo_accion_id', $corto_plazo_accion_id);
    //         return datatables()
    //             ->eloquent($operaciones)
    //             ->addColumn('btn_operaciones', view('operaciones.btn_operaciones'))
    //             ->toJson();
    //     }
    // }

    // public function listarActividades(Request $request, $operacion_id)
    // {
    //     if($request->ajax())
    //     {
    //         $actividades = Actividades::where('operacion_id', $operacion_id);
    //         return datatables()
    //             ->eloquent($actividades)
    //             ->addColumn('btn_actividades', view('actividades.btn_actividades'))
    //             ->toJson();
    //     }
    // }

    // public function listarTareasEspecificas(Request $request, $actividad_id)
    // {
    //     if($request->ajax())
    //     {
    //         $tareas_especificas = TareasEspecificas::where('actividad_id', $actividad_id);
    //         return datatables()
    //             ->eloquent($tareas_especificas)
    //             ->addColumn('btn_tarea_especifica', view('tareas_especificas.btn_tarea_especifica'))
    //             ->toJson();
    //     }
    // }

    // public function listarPartidas(Request $request)
    // {
    //     if($request->ajax())
    //     {
    //         return datatables()
    //             ->eloquent(Partidas::query())
    //             ->addColumn('btn_partida', view('partidas.btn_partida'))
    //             ->toJson();
    //     }
    // }

    // public function listarItems(Request $request, $actividad)
    // {
    //     if($request->ajax())
    //     {
    //         $items = Actividades::join('items', 'actividades.id', '=', 'items.actividad_id')
    //             ->join('partidas', 'items.partida_id', '=', 'partidas.id')
    //             ->select('partidas.nombre_partida', 'items.*')
    //             ->where('actividades.id', $actividad);

    //         return datatables()
    //             ->eloquent($items)
    //             ->addColumn('btn_items', view('items.btn_items'))
    //             ->toJson();
    //     }
    // }

    // public function listarPlanificacion(Request $request, $corto_plazo_accion)
    // {
    //     if($request->ajax())
    //     {
    //         $planificacion = Planificaciones::where('corto_plazo_accion_id', $corto_plazo_accion);

    //         return datatables()
    //             ->eloquent($planificacion)
    //             ->addColumn('btn_planificacion', view('planificacion.btn_planificacion'))
    //             ->toJson();
    //     }
    // }

    public function consulta(Request $request)
    {
        /* return DB::table('usuarios')
            ->join('trabajadores', 'usuarios.id',"=",'trabajadores.usuario_id')
            ->select('trabajadores.nombre')
            ->where('trabajadores.usuario_id', 1)
            ->get(); */

        /* return Usuario::join("trabajadores", "trabajadores.usuario_id", "=", "usuarios.id")
            //->select("trabajadores.nombre")
            ->select("trabajadores.*")
            ->where('trabajadores.usuario_id', 1) buscamos al trabajador donde el id sea 1
            ->first();  el primer registro que encuentre*/
        

        //recuperamos los datos del usuario
        //$user = Usuario::find(20);
        //y podremos acceder a las propiedades del trabajador
        //return $user->trabajadores->nombre;

        //$data = Unidades::join("trabajadores", "trabajadores.unidad_id", "=", "unidades.id_unidad")->get();
        //$data = Usuario::join("trabajadores", "trabajadores.usuario_id", "=", "usuarios.id")->get();
        //$data = PeiObjetivosEspecificos::all()->where('accion_mediano_plazo_id', 17);
        /* $data = Gerencias::join('unidades', 'gerencias.id', '=', 'unidades.gerencia_id')
                ->join('trabajadores', 'unidades.id', '=', 'trabajadores.unidad_id')
                ->join('usuarios', 'usuarios.id', '=', 'trabajadores.usuario_id')
                ->select('gerencias.*', 'trabajadores.nombre', 'unidades.nombre_unidad')
                ->where('usuarios.id', Auth::guard('usuario')->user()->id)->first(); */

        //return $data;
        // return Trabajadores::query()->whereNotIn('id', Usuario::query()->select('trabajador_id'))->get();

        // return Actividades::join('items', 'actividades.id', '=', 'items.actividad_id')
        //     ->join('partidas', 'items.partida_id', '=', 'partidas.id')
        //     ->select('partidas.codigo_partida', 'items.*')
        //     ->where('actividades.id', 10)->get();

        // $meses = [];
        // // return $m;
        // for($i= 4;$i <= 9; $i++)
        // {
        //     array_push($meses, $i);
        // }
        // return $meses;

        // return DB::table('roles')->get();

        // ********************************************

        // return $corto_plazo_acciones = Trabajadores::join('corto_plazo_acciones', 'trabajadores.id', '=', 'corto_plazo_acciones.trabajador_id')
        // ->select(
        //     'corto_plazo_acciones.uuid',
        //     'corto_plazo_acciones.accion_corto_plazo', 'corto_plazo_acciones.fecha_inicio',
        //     'corto_plazo_acciones.fecha_fin', 'trabajadores.poa_evaluacion'
        // )
        // ->where('trabajadores.id', Auth::guard('usuario')->user()->trabajador->id)->get();

        // *********************************************
        // $corto_plazo_acciones = CortoPlazoAcciones::query()
        //     ->addSelect([
        //         'count_planificaciones' => Planificaciones::selectRaw('COUNT(*)')
        //         ->whereColumn('planificaciones.corto_plazo_accion_id', 'corto_plazo_acciones.id')
        //     ])->get();
        // return $corto_plazo_acciones;

        // *********************************************

        // $csvFile = fopen(base_path("database/data/partidas.csv"), "r");
        // $fila = 1;
        //     if (($gestor = fopen(base_path("database/data/partidas.csv"), "r")) !== FALSE) {
        //         while (($datos = fgetcsv($csvFile, 2000, ";")) !== FALSE) {
        //             $numero = count($datos);
        //             echo "<p> $numero de campos en la línea $fila: <br /></p>\n";
        //             $fila++;
        //             for ($c=0; $c < $numero; $c++) {
        //                 echo $datos[$c] . "<br />\n";
        //             }
        //         }
        //         fclose($gestor);
        //     }

        // *********************************************

        // return Actividades::where('operacion_id', 1)
        //     ->addSelect([
        //         'ss' => Items::selectRaw('SUM(presupuesto)')
        //         ->whereColumn('actividades.id', 'items.actividad_id')
        //     ])
        //     ->get();

        $actividades = Actividades::select('actividades.*');
        return datatables($actividades)
            ->addColumn('items_presupuesto', function (Actividades $actividades){
                return $actividades->items()->sum('presupuesto');
            })
            ->make(true);
        
    }
}
