<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DemographicDataRequest extends FormRequest
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
            'electricity' => 'required';
            'pet' => 'required';
            'refrigerator' => 'required';
            'patient_id' => 'required';
            'typeHeating_id' => 'required';
            'typeLivingPlace_id' => 'required';
            'typeWater_id' => 'required';
        ];
    }
}
