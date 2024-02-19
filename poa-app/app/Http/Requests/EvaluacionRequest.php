<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class EvaluacionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // $fecha_actual = Carbon::now();
        $fecha_actual = Carbon::createFromDate("2023-04-01");
        
        switch ($fecha_actual->month) {
            case 2: case 3:
                // $resultado_esperado = '';
                break;

            case 4: case 5: case 6:
                if ($this->isMethod('post')) { 
                    $resultado_esperado = $this->route('corto_plazo_accion')->planificacion->primer_trimestre;
                } elseif ($this->isMethod('put')){ 
                    $resultado_esperado = $this->route('evaluacion')->corto_plazo_accion->planificacion->primer_trimestre;
                }
                break;
                
            case 7: case 8: case 9:
                if ($this->isMethod('post')) { 
                    $resultado_esperado = $this->route('corto_plazo_accion')->planificacion->segundo_trimestre;
                } elseif ($this->isMethod('put')){ 
                    $resultado_esperado = $this->route('evaluacion')->corto_plazo_accion->planificacion->segundo_trimestre;
                }
                break;

            case 10: case 11:
                if ($this->isMethod('post')) { 
                    $resultado_esperado = $this->route('corto_plazo_accion')->planificacion->tercer_trimestre;
                } elseif ($this->isMethod('put')){ 
                    $resultado_esperado = $this->route('evaluacion')->corto_plazo_accion->planificacion->tercer_trimestre;
                }
                break;

            case 12: case 1:
                if ($this->isMethod('post')) { 
                    $resultado_esperado = $this->route('corto_plazo_accion')->planificacion->cuarto_trimestre;
                } elseif ($this->isMethod('put')){ 
                    $resultado_esperado = $this->route('evaluacion')->corto_plazo_accion->planificacion->cuarto_trimestre;
                }
                break;
            
            default:
                #code
                break;
        }

        if (request()->isMethod('post')) {
            $presupuesto_restante = $this->route('corto_plazo_accion.presupuesto_programado') - $this->route('corto_plazo_accion')->evaluaciones->sum('presupuesto_ejecutado');
        } elseif (request()->isMethod('put')){
            $presupuesto_restante = $this->route('evaluacion')->corto_plazo_accion->presupuesto_programado - $this->route('evaluacion')->corto_plazo_accion->evaluaciones->sum('presupuesto_ejecutado') + $this->route('evaluacion')->presupuesto_ejecutado;
        }
        
        return [
            'resultado_logrado' => ['required', 'numeric', 'min:0', "max:$resultado_esperado"],
            'presupuesto_ejecutado' => ['required', 'numeric', 'min:0', "max:$presupuesto_restante"]
        ];
    }

    public function messages()
    {
        if($this->isMethod('post')){
            $presupuesto_restante = $this->route('corto_plazo_accion.presupuesto_programado') - $this->route('corto_plazo_accion')->evaluaciones->sum('presupuesto_ejecutado');
            return [
                // 'resultado_logrado.required' => $this->route('corto_plazo_accion')->planificacion
                'presupuesto_ejecutado.min' => 'El campo presupuesto ejecutado debe ser al menos 0.00 Bs.',
                'presupuesto_ejecutado.max' => "No debe ser mayor al presupuesto restante de $presupuesto_restante Bs.",
            ];
        } elseif ($this->isMethod('put')){
            $presupuesto_restante = $this->route('evaluacion')->corto_plazo_accion->presupuesto_programado - $this->route('evaluacion')->corto_plazo_accion->evaluaciones->sum('presupuesto_ejecutado') + $this->route('evaluacion')->presupuesto_ejecutado;
            return [
                'presupuesto_ejecutado.min' => 'El campo presupuesto ejecutado debe ser al menos 0.00 Bs.',
                'presupuesto_ejecutado.max' => "No debe ser mayor al presupuesto restante de $presupuesto_restante Bs.",
            ];
        }
    }
}
