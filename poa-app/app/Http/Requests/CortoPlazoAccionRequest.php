<?php

namespace App\Http\Requests;

use App\Models\Pilares;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class CortoPlazoAccionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; //cambiamos a true
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        //obtenemos la gestion del ultimo pilar creado
        $gestion_pilar = Pilares::select('gestion_pilar')->groupBy('gestion_pilar')->orderBy('gestion_pilar', 'desc')->first();
        $year_creacion = Carbon::now()->addYear()->year;
        // $year_creacion = 2022;
        return [
            'gestion' => ['required', 'digits:4', 'numeric', "max:$year_creacion", "min:$year_creacion"],
            'accion_corto_plazo' => 'required',
            'resultado_esperado' => ['required', 'numeric', 'min:0', 'max:100'],
            'presupuesto_programado' => ['required', 'numeric', 'min:0'],
            'fecha_inicio' => ['required', "after_or_equal:$gestion_pilar->gestion_pilar-01-01"],
            'fecha_fin' => ['required', 'after:fecha_inicio', "before_or_equal:$gestion_pilar->gestion_pilar-12-31"],
        ];
    }
}
