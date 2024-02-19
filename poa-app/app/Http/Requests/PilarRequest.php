<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class PilarRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; //////////////////////////// debemos cambiar a true el valor para que nos funciones el request
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $gestion = Carbon::now()->addYear();
        $min_gestion = Carbon::now()->addYear();
        // $min_gestion = Carbon::now()->subYear(1);
        return [
            'codigo_pilar' => ['required', 'numeric', 'min:0', 'max:99'],
            'nombre_pilar' => ['required', 'string'],
            'gestion_pilar' => ['required', 'numeric', "max:$gestion->year", "min:$min_gestion->year"],
        ];
    }

    public function messages()
    {
        return [
            'gestion_pilar.required' => 'El campo gestion es requerido.',
            'gestion_pllar.numeric' => 'El campo gestion debe ser un numero',
        ];
    }
}