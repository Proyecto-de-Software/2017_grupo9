<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MedicalCheckupRequest extends FormRequest
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
            'date' => 'required',
            'weight' => 'required',
            //'complete_vaccines ' => 'required',
            'complete_vaccines_observation' => 'required',
            //'correct_maturation' => 'required',
            'correct_maturation_observation' => 'required',
            //'normal_physical_examination' => 'required',
            'normal_physical_examination_observation' => 'required',
            'patient_id' => 'required'
        ];
    }
}
