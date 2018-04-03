<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Rol extends Model
{
    //
    public function users(){
    	return $this->belongsToMany('User');
    }
    /*
    public function permits(){
    	return $this->belongsToMany('\App\Permit','permit_id')->withPivot('rol_permit','status');
    }
    */
}
