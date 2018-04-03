<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RolPermit extends Model
{
    protected $table = 'rol_permit';

    public function rols(){
    	return $this->belongsTo('\App\Rol','rol');
    }
    public function permits(){
    	return $this->belongsTo('\App\Permit','permit');
    }
}
