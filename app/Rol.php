<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    //
    public function users(){
    	return $this->belongsToMany('\App\User','user_rol')->withPivot('user_id','status');
    }
    public function permits(){
    	return $this->belongsToMany('\App\Permit','permit_id')->withPivot('rol_permit','status');
    }
}
