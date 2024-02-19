<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MetaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; //CAMBIAMOS EL VALOR A TRUE
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'codigo_meta' => ["required", "numeric", "min:0", "max:99"],
            'nombre_meta' => 'required|string',
        ];
    }
}
