<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UnidadRequest extends FormRequest
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
            'nombre_unidad' => ['required', 'regex:/^[\pL\s\-]+$/u'],
            'gerencia_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'nombre_unidad.regex' => 'El campo no admite valores numericos',
        ];
    }
}
