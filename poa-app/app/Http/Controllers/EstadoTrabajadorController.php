<?php

namespace App\Http\Controllers;

use App\Models\CortoPlazoAcciones;
use App\Models\Trabajadores;
use App\Models\Unidades;
use App\Models\Usuario;
// use Barryvdh\DomPDF\Facade as PDF;
use Elibyy\TCPDF\Facades\TCPDF as PDF;
use Illuminate\Http\Request;

class EstadoTrabajadorController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:PLANIFICADOR']);
    }
    
    public function index(Request $request)
    {
        if($request->ajax()){
            $trabajadores = Usuario::join('trabajadores', 'trabajadores.id', '=', 'usuarios.trabajador_id')
                ->join('unidades', 'unidades.id', '=', 'trabajadores.unidad_id')
                ->join('gerencias', 'gerencias.id', '=', 'unidades.gerencia_id')
                ->select('trabajadores.*', 'unidades.nombre_unidad', 'gerencias.nombre_gerencia')
                ->whereHas("roles", function($q){ $q->whereNotIn("name", ["ADMIN", "PLANIFICADOR"]); });

            return datatables()
                ->eloquent($trabajadores)
                // ->addColumn('btn_estado_trabajadores', 'estado_trabajadores.btn_estado_trabajadores')
                // ->rawColumns(['btn_estado_trabajadores'])
                ->toJson();
        }
        return view('estado_trabajadores.index');
    }

    public function poa_status(Request $request, Trabajadores $trabajador)
    {
        $estado_poa = $trabajador->poa_status == '0' ? '1' : '0';
        $trabajador->update([
            'poa_status' => $estado_poa
        ]);
    }

    public function poa_evaluacion(Request $request, Trabajadores $trabajador)
    {
        $estado_evaluacion = $trabajador->poa_evaluacion == '0' ? '1' : '0';
        $trabajador->update([
            'poa_evaluacion' => $estado_evaluacion,
        ]);
    }

    public function habilitar_creacion_all()
    {
        $trabajadores = Trabajadores::select('trabajadores.*')->join('usuarios', 'usuarios.trabajador_id', '=', 'trabajadores.id')->get();
        foreach($trabajadores as $trabajador){
            $trabajador->update([
                'poa_status' => '1'
            ]);
        }
        // return view('estado_trabajadores.index');
    }

    public function deshabilitar_creacion_all(){
        $trabajadores = Trabajadores::select('trabajadores.*')->join('usuarios', 'usuarios.trabajador_id', '=', 'trabajadores.id')->get();
        foreach($trabajadores as $trabajador){
            $trabajador->update([
                'poa_status' => '0'
            ]);
        }
        // return view('estado_trabajadores.index');
    }

    public function habilitar_evaluacion_all(){
        // obtenemos todos los trabajadores que cuenten con un usuario definido con la relacion en el modelo
        $trabajadores = Trabajadores::has('usuario')->get();
        $trabajadores->each(function($trabajador){
            $trabajador->update([
                'poa_evaluacion' => '1' 
            ]);   
        });
    }

    public function deshabilitar_evaluacion_all(){
        // obtenemos todos los trabajadores que cuenten con un usuario definido con la relacion en el modelo
        $trabajadores = Trabajadores::has('usuario')->get();
        $trabajadores->each(function($trabajador){
            $trabajador->update([
                'poa_evaluacion' => '0' 
            ]);   
        });
    }
}
