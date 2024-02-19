<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PeiObjetivoEspecificoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; //CAMBIAMOS A TRUE
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'objetivo_institucional' => 'required',
            'ponderacion' => 'required|numeric|min:1|max:100',
            'indicador_proceso' => ['required'],
            'gerencia_id' => 'required'
        ];
    }
}
