<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DemographicData extends Model
{
    protected $fillable = [
        //'name', 'email', 'password',
        'electricity', 'pet', 'refrigerator', 'typeHeating_id', 'typeLivingPlace_id', 'typeWater_id', 'created_at', 'update_at',
    ];

    public static function getPatientId($id){
       $id = DB::table('demographic_datas')->where('patient_id', $id)->value('patient_id');
    }

    public function patient(){
        return $this->hasOne('\App\Patient');
    }

    public function typeWater(){
        return $this->hasOne('\App\TypeWater');
    }

    public function typeLivingPlace(){
        return $this->hasOne('\App\TypeLivingPlace');
    }

    public function typeHeating(){
        return $this->hasOne('\App\TypeHeating');
    }
}
