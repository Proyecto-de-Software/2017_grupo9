<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        //'name', 'email', 'password',
        'first_name', 'last_name', 'address', 'phone', 'birthdate', 'gender', 'type_document', 'document_number', 'health_insurance', 'demographic_data_id' ,'created_at', 'update_at',
    ];

    public function demographicData(){
    	return $this->hasOne('App\DemographicData');
    }

    public function scopeName($query, $name){
    	if(trim($name) != ""){

    		$query->where(\DB::raw("CONCAT(first_name, ' ', last_name)"), "LIKE", "$name%");
    	}
    }

}
