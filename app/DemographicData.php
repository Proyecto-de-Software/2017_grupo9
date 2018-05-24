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

    public static function patient(){
       return $this->belongsTo('App\Patient');
    }
}
