<?php

namespace App\Http\Livewire\VerPoas;

use App\Models\CortoPlazoAcciones;
use App\Models\Gerencias;
use App\Models\Pilares;
use App\Models\Unidades;
use Carbon\Carbon;
use Livewire\Component;

class VerPoasComponent extends Component
{
    public $gerencias;
    public $unidades;
    public $corto_plazo_acciones;

    public $SelectedGerencia = NULL;
    public $SelectedtUnidad = NULL;

    public function mount(){
        $this->gerencias = Gerencias::all();
        $this->unidades = collect();
    }

    public function render()
    {
        return view('livewire.ver-poas.ver-poas-component');
    }

    public function updatedSelectedGerencia($gerencia){
        $this->SelectedtUnidad = NULL;
        $this->unidades = Unidades::where('gerencia_id', $gerencia)->get();
    }

    public function updatedSelectedtUnidad($unidad_uuid){
        if($unidad_uuid !== ""){
            $unidad = Unidades::where('uuid', $unidad_uuid)->first();

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
                $this->corto_plazo_acciones = CortoPlazoAcciones::join('trabajadores', 'trabajadores.id', '=', 'corto_plazo_acciones.trabajador_id')
                ->join('unidades', 'unidades.id', '=', 'trabajadores.unidad_id')
                ->join('pei_objetivos_especificos', 'pei_objetivos_especificos.id', '=', 'corto_plazo_acciones.pei_objetivo_especifico_id')
                ->join('mediano_plazo_acciones', 'mediano_plazo_acciones.id', '=', 'pei_objetivos_especificos.mediano_plazo_accion_id')
                ->join('resultados', 'resultados.id', 'mediano_plazo_acciones.resultado_id')
                ->join('metas', 'metas.id', '=', 'resultados.meta_id')
                ->join('pilares', 'pilares.id', '=', 'metas.pilar_id')
                ->select('corto_plazo_acciones.*')
                ->where('pilares.gestion_pilar', $gestion)
                ->where('unidades.id', $unidad->id)
                ->get();
            } else {
                $this->corto_plazo_acciones = [];
            }

        }
    }

}
