<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MedicalCheckup extends Model
{
    protected $fillable = [
        //'name', 'email', 'password',
        'date', 'weight', 'height', 'complete_vaccines', 'complete_vaccines_observation', 'correct_maturation', 'correct_maturation_observation', 'normal_physical_examination', 'normal_physical_examination_observation', 'pc', 'ppc', 'food_description', 'general_observation', 'patient_id', 'user_id' ,'created_at', 'update_at',
    ];

    public function patient(){
    	return $this->hasOne('App\Patient');
    }

    public function user(){
    	return $this->hasOne('App\User');
    }
}