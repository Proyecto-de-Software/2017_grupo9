<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Role;
use Zizaco\Entrust\Traits\EntrustUserTrait;//importamos la clase HasRole

class User extends Authenticatable
{
    use Notifiable;
    use EntrustUserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        //'name', 'email', 'password',
        'first_name', 'last_name', 'email', 'password', 'username', 'active', 'created_at', 'update_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roles(){
       return $this->belongsToMany('App\Role','role_user');
    }

    public function scopeFilter($query, $username, $active){
        if(!is_numeric($active)){
            $active = 0;
        }
        if(trim($username) != ""){
            //var_dump($username." ". $active);
            $query->where('username', 'like', "%$username%")->where('active',$active)->get();
        }
        if($active != null){
            $query->where('active',$active)->get();            
        }
    }
}
