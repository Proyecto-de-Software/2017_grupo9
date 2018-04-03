<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRol extends Model

{
    protected $table = 'user_rol';
    public $timestamps = false;

    public function rols(){
    	return $this->belongsTo('\App\Rol','rol');
    }
    public function users(){
    	return $this->belongsTo('\App\User','user');
    }
}
