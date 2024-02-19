<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResultadoRequest extends FormRequest
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
            'codigo_resultado' => ['required', 'numeric', 'min:0', 'max:99'],
            'nombre_resultado' => 'required',
        ];
    }
}
