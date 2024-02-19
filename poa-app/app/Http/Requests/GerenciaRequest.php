<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GerenciaRequest extends FormRequest
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
            'nombre_gerencia' => ['required', 'regex:/^[\pL\s\-]+$/u'], //con regex: podemos incluir expresiones regulares
        ];
    }

    public function messages()
    {
        return [
            'nombre_gerencia.regex' => 'El campo no admite valores numericos',
        ];
    }
}
