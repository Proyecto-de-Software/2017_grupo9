<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DemographicData extends Model
{
    protected $fillable = [
        //'name', 'email', 'password',
        'electricity', 'pet', 'refrigerator', 'created_at', 'update_at',
    ];

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
