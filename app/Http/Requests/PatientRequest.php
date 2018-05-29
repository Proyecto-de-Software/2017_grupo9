<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatientRequest extends FormRequest
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
            'birthdate' => 'required',
            'gender' => 'required',
            'type_document' => 'required',
            'document_number' => 'required',
            'address' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'El nombre es obligatorio',
            'last_name.required'  => 'El apellido es obligatorio',
            'birthdate.required'  => 'El nombre de usuario es obligatorio',
            'gender.required'  => 'El género es obligatoria',
            'type_document.required'  => 'El tipo de documento es obligatorio',
            'document_number.required'  => 'El número de documento es obligatorio',
            'address.required'  => 'La dirección es obligatoria'
        ];
    }
}
