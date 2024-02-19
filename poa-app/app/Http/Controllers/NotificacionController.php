<?php

namespace App\Http\Controllers;

use App\Models\CortoPlazoAcciones;
use App\Models\Pilares;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NotificacionController extends Controller
{
    public function CountStatusAccionesCorto()
    {
        $date = Carbon::now()->addYear();
        $pilares = Pilares::select('gestion_pilar')
            ->groupBy('gestion_pilar')
            ->orderBy('gestion_pilar', 'ASC')
            ->get();

        if ($pilares->count()) {
            // si existe un pilar para la gestion siguiente se buscara los pilares con la gestion siguiente, si no se mostrara los pilares de la ultima gestion creada
            if ($pilares->last()->gestion_pilar == $date->year) {
                $gestion = $date->year;
            }else{
                $gestion = $pilares->last()->gestion_pilar;
            }
        }

        if (isset($gestion)) {
            $corto_plazo_acciones = CortoPlazoAcciones::join('trabajadores', 'trabajadores.id', '=', 'corto_plazo_acciones.trabajador_id')
            ->join('unidades', 'unidades.id', '=', 'trabajadores.unidad_id')
            ->join('pei_objetivos_especificos', 'pei_objetivos_especificos.id', '=', 'corto_plazo_acciones.pei_objetivo_especifico_id')
            ->join('mediano_plazo_acciones', 'mediano_plazo_acciones.id', '=', 'pei_objetivos_especificos.mediano_plazo_accion_id')
            ->join('resultados', 'resultados.id', 'mediano_plazo_acciones.resultado_id')
            ->join('metas', 'metas.id', '=', 'resultados.meta_id')
            ->join('pilares', 'pilares.id', '=', 'metas.pilar_id')
            ->select('corto_plazo_acciones.*')
            ->where('pilares.gestion_pilar', $gestion)
            ->where('corto_plazo_acciones.status', 'presentado')
            // ->where('unidades.id', $unidad->id)
            ->get()
            ->count();
        } else {
            $corto_plazo_acciones = 0;
        }

        return $corto_plazo_acciones;
    }

    public function pruebas()
    {
        return view('pruebas');
    }
}
