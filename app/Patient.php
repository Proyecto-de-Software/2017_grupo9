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

    public function medicalCheckup()
	{
	    return $this->hasMany('App\medicalCheckup');
	}

    public function scopeName($query, $name){
    	if(trim($name) != ""){

    		$query->where(\DB::raw("CONCAT(first_name, ' ', last_name)"), "LIKE", "$name%");
    	}
    }

    public function scopeDocument($query, $typeDocument, $documentNumber){
    	if(trim($documentNumber) != ""){
    		$query->where('document_number', $documentNumber)->get();
    	}
    }

}
