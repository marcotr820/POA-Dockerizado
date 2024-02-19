<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; //cambiamos a true
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'password' => ['required', 'regex:/^[a-zA-Z0-9\_\-]{0,20}$/', 'min:3'],
            // same verifica que los campos sean iguales
            'password_confirm' => ['same:password']
        ];
    }

    public function messages()
    {
        return [
            'password.regex' => 'El formato del campo es inválido.',
            'password.required' => 'La contraseña es obligatoria.', 
            'password.min' => 'Elija una contraseña mas larga.',
            'password_confirm.same' => 'Las contraseñas no coinciden.',
        ];
    }
}
