<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemRequest extends FormRequest
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
        return [
            'bien_servicio' => ['required'],
            'presupuesto' => ['required', 'numeric', 'min:0'],
            'fecha_requerida' => ['required'],
            'partida_id' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'partida_id.required' => 'el campo partida es obligatorio'
        ];
    }
}
