<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required|unique:users,username,'.$this->user->id,
            'email' => 'required|unique:users,email,'.$this->user->id,
            'role' => 'required',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'El nombre es obligatorio',
            'last_name.required'  => 'El apellido es obligatorio',
            'username.required'  => 'El nombre de usuario es obligatorio',
            'password.required'  => 'La contraseña es obligatoria',
            'email.required'  => 'El email es obligatorio',
            'role.required'  => 'Es obligatorio elegir al menos un rol',
            'password.confirmed' => 'Ambas contraseñas deben coincidir'
        ];
    }
}
