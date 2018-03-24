<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permit extends Model
{
    public function rols(){
    	return $this->belongsToMany('\App\Rol','rol_id')->withPivot('rol_permit','status');
    }  
}
