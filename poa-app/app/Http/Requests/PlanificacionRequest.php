<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlanificacionRequest extends FormRequest
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
            'primer_trimestre' => ['min:1', 'max:100', 'sometimes', 'required', 'numeric'],
            'segundo_trimestre' => ['min:1', 'max:100', 'sometimes', 'required', 'numeric'],
            'tercer_trimestre' => ['min:1', 'max:100', 'sometimes', 'required', 'numeric'],
            'cuarto_trimestre' => ['min:1', 'max:100', 'sometimes', 'required', 'numeric']
        ];
    }
}
