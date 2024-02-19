<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ActividadRequest extends FormRequest
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
        if(request()->isMethod('post')){
            $nombre_actividadRule = ['required'];
            // $nombre_actividadRule = ['required', 'unique:actividades'];
        } 
        elseif (in_array($this->method(), ['PUT', 'PATCH'])) {
            // $nombre_actividadRule = ['required', 'unique:actividades,nombre_actividad,'. $this->actividad->id];
            $nombre_actividadRule = [
                'required', 
                // Rule::unique('actividades')->ignore($this->actividad->id) //indicamos que ignore el id de la actividad al actualizar
            ];
        }
        return [
            // 'nombre_actividad' => 'required|unique:actividades,nombre_actividad,' . $this->actividad->id,
            'nombre_actividad' => $nombre_actividadRule, 
            'resultado_esperado' => ['required']
        ];
    }

    protected function prepareForValidation()
    {
        
    }

    public function messages()
    {
        return [
            'nombre_actividad.required' => 'la actividad debe tener un nombre'
        ];
    }
}
