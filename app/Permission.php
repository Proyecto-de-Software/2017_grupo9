<?php

namespace App;

use Zizaco\Entrust\EntrustRole;
use App\Role;

class Permission extends EntrustPermission
{
    public function roles(){
       return $this->belongsToMany('App\Role','permission_role');
    }
}
