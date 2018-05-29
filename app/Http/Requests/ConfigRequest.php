<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConfigRequest extends FormRequest
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
            'title' => 'required',
            'email_contact' => 'required',
            'elements_for_page' => 'required',
            'state' => 'required',
            'hospital_description' => 'required',
            'guard_description' => 'required',
            'specialties_description' => 'required'
        ];
        
    }

    public function messages()
    {
        return [
            'title.required' => 'Debe configurar un titulo de pagina',
            'email_contact.required' => 'Debe configurar un email de contacto',
            'elements_for_page.required' => 'Debe configurar los elementos por pagina',
            'hospital_description.required' => 'Debe configurar una descripcion de hospital',
            'guard_description.required' => 'Debe configurar una descripcion de guardia',
            'specialties_description.required' => 'Debe configurar una descripcion de especialidades'
        ];       
    }
}
