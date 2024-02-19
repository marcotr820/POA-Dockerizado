<?php
namespace App\Http\Controllers;

use App\Http\Requests\PlanificacionRequest;
use App\Models\CortoPlazoAcciones;
use App\Models\Pilares;
use App\Models\Planificaciones;
use App\Models\Trabajadores;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class PlanificacionController extends Controller
{
    public function index(Request $request, CortoPlazoAcciones $corto_plazo_accion)
    {
        $url_anterior = redirect()->getUrlGenerator()->previous();
        if($request->ajax()){
            $query = CortoPlazoAcciones::join('planificaciones', 'planificaciones.corto_plazo_accion_id', '=', 'corto_plazo_acciones.id')
                ->select('planificaciones.*', 'corto_plazo_acciones.fecha_inicio')
                ->where('corto_plazo_acciones.id', $corto_plazo_accion->id);
            return datatables($query)->make(true);
        }

        $meses = [];
        $inicio_carbon = Carbon::parse($corto_plazo_accion->fecha_inicio);
        $fin_carbon = Carbon::parse($corto_plazo_accion->fecha_fin);
        $inicio = $inicio_carbon->month;
        $fin = $fin_carbon->month;
        for($i=$inicio ; $i <= $fin ; $i++){ //fecha fin 1 no jalara
            array_push($meses, $i);
        }

        $trimestres = [];
        // $trimestres = ["1er_trimestre", "2do_trimestre", "3er_trimestre", "4to_trimestre"];
        foreach($meses as $mes){
            switch ($mes) {
                case 1: case 2: case 3:
                    if (! in_array("primer_trimestre", $trimestres)){
                        array_push($trimestres, 'primer_trimestre');
                    }
                break;

                case 4: case 5: case 6:
                    if (! in_array("segundo_trimestre", $trimestres)){
                        array_push($trimestres, 'segundo_trimestre');
                    }
                break;

                case 7: case 8: case 9:
                    if (! in_array("tercer_trimestre", $trimestres)){
                        array_push($trimestres, 'tercer_trimestre');
                    }
                break;
                
                default:
                    if (! in_array("cuarto_trimestre", $trimestres)){
                        array_push($trimestres, 'cuarto_trimestre');
                    }
                break;
            }
            // if($mes === 1 || $mes === 2 || $mes === 3)
            // {
            //     if (! in_array("primer_trimestre", $trimestres)){
            //         array_push($trimestres, 'primer_trimestre');
            //     }
            // }elseif($mes === 4 || $mes === 5 || $mes === 6)
            // {
            //     if (! in_array("segundo_trimestre", $trimestres)){
            //         array_push($trimestres, 'segundo_trimestre');
            //     }
            // }elseif($mes === 7 || $mes === 8 || $mes === 9)
            // {
            //     if (! in_array("tercer_trimestre", $trimestres)){
            //         array_push($trimestres, 'tercer_trimestre');
            //     }
            // }
            // else
            // {
            //     if (! in_array("cuarto_trimestre", $trimestres)){
            //         array_push($trimestres, 'cuarto_trimestre');
            //     }
            // }
        }
        return view('planificacion.index', compact('corto_plazo_accion', 'trimestres', 'url_anterior'));
    }

    public function acciones_corto_plazo_planificacion()
    {
        abort_if(auth('usuario')->user()->trabajador->poa_status != 1, 403);

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
            $corto_plazo_acciones = CortoPlazoAcciones::join('trabajadores', 'trabajadores.id', '=', 'corto_plazo_acciones.trabajador_id')
            ->join('unidades', 'unidades.id', '=', 'trabajadores.unidad_id')
            ->join('pei_objetivos_especificos', 'pei_objetivos_especificos.id', '=', 'corto_plazo_acciones.pei_objetivo_especifico_id')
            ->join('mediano_plazo_acciones', 'mediano_plazo_acciones.id', '=', 'pei_objetivos_especificos.mediano_plazo_accion_id')
            ->join('resultados', 'resultados.id', 'mediano_plazo_acciones.resultado_id')
            ->join('metas', 'metas.id', '=', 'resultados.meta_id')
            ->join('pilares', 'pilares.id', '=', 'metas.pilar_id')
            ->select('corto_plazo_acciones.*')
            ->where('pilares.gestion_pilar', $gestion)
            ->where('unidades.id', auth('usuario')->user()->trabajador->unidad->id)
            ->where('corto_plazo_acciones.status', 'aprobado')->get();
            // ->addSelect(['count_planificacion' => Planificaciones::selectRaw('COUNT(*)')->whereColumn('corto_plazo_accion_id', 'corto_plazo_acciones.id')]);
        } else {
            $corto_plazo_acciones = [];
        }

        return view('planificacion.accion_corto_plazo_planificacion', compact('corto_plazo_acciones'));
    }

    public function store(PlanificacionRequest $request, CortoPlazoAcciones $corto_plazo_accion)
    {
        if ($request->collect()->except('_token')->sum() != 100) {
            // mandamos mensaje de error de las credenciales y la mostramos
            throw ValidationException::withMessages([
                'error_validacion' => ['los campos deben sumar el 100%'] //mensage en la carpeta lang/es/auth
            ]);
        }

        if($corto_plazo_accion->planificacion()->exists()){
            return abort(404); //si la accion corto plazo ya tiene una planificacion validamos que no se pueda insertar mas de una
        }
        else{
            Planificaciones::create([
                'primer_trimestre' => $request->input('primer_trimestre', 0), //si existe el valor lo inserta sino toma el valor de 0
                'segundo_trimestre' => $request->input('segundo_trimestre', 0),
                'tercer_trimestre' => $request->input('tercer_trimestre', 0),
                'cuarto_trimestre' => $request->input('cuarto_trimestre', 0),
                'corto_plazo_accion_id' => $corto_plazo_accion->id
            ]);
        }
        
    }

    public function destroy(Planificaciones $planificacion)
    {
        $corto = CortoPlazoAcciones::join('planificaciones', 'planificaciones.corto_plazo_accion_id', '=', 'corto_plazo_acciones.id')
        ->select('corto_plazo_acciones.*')
        ->where('corto_plazo_acciones.id', $planificacion->corto_plazo_accion_id)->first();

        $corto->update([
            'status' => '2' //actualizamos el status de la accion para que nos vuelva a mostrar la opcion de crear planificacion
        ]);

        $planificacion->delete();
        
    }
}
