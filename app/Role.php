<?php

namespace App;
use App\User;
use App\Permission;
use Zizaco\Entrust\EntrustRole;
use Illuminate\Database\Eloquent\Model;

class Role extends EntrustRole
{
    
    public function users()
    {
        return $this->belongsToMany('App\User','role_user');
    }

    public function permissions()
    {
        return $this->belongsToMany('App\Permission','permission_role');
    }
}
