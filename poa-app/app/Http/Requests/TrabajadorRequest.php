<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TrabajadorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // ========= se debe cambiar a true para no generar errores =====================
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // $this === $request
        // dd($this->route('trabajador'));
        return [
            'documento' => ['required','numeric', 'regex:/^.{7,8}$/', Rule::unique('trabajadores')->ignore( $this->route('trabajador') )],
            'nombre' => ['required', 'regex:/^[a-zA-ZÀ-ÿ\s]{1,40}$/'], //Letras y espacios, pueden llevar acentos.
            'cargo' => ['required', 'regex:/^[a-zA-ZÀ-ÿ\s]{1,40}$/'],
            'unidad_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'documento.regex' => 'Solo se permite 7 u 8 digitos',
            'nombre.regex' => 'Este campo solo puede contener letras',
            'cargo.regex' => 'Este campo solo puede contener letras'
        ];
    }
}
