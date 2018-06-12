<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{

    public function __construct()
    {
      $this->middleware('auth');

    }

    
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */    
    public function index(Request $request)
    {
        if(!$this->can('user_index')){
            return redirect()->route('home'); 
        }
        $username = $request->get('username');
        $active = $request->get('active');

        $users = User::filter($username, $active)->orderBy('id', 'ASC')->paginate(5);

        return view('users.index', compact('users'))->with('username', $username)->with('active',$active)->with('config',$this->getConfiguration());

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!$this->can('user_new')){
            return redirect()->route('home'); 
        }
        $roles = Role::get();
        return view('users.create')->with('roles',$roles)->with('config',$this->getConfiguration());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {   
        if(!$this->can('user_new')){
            return redirect()->route('home'); 
        }
        $user = new User();

        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->active = true;
        $user->username = $request->input('username');
        $user->password = $request->input('password');
        $user->email = $request->input('email');
        $user->save();
        foreach($request->input('role') as $idRole){
            $user->roles()->attach($idRole);
        }
        $user->save();
       
        return redirect()->route('user.show',$user->id);
    }

    /**
    * Display the specified resource.
    *
    * @param  \App\User  $user
    * @return \Illuminate\Http\Response
    */
    public function show(User $user)
    {
        if(!$this->can('user_show')){
            return redirect()->route('home'); 
        }
        $roles = $user->roles()->get()->map(function($rol,$key){
                                             return $rol->name;
                                             })->toArray();
        
        return view('users.show')->with('user',$user)->with('roles',$roles)->with('config',$this->getConfiguration());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if(!$this->can('user_update')){
            return redirect()->route('home'); 
        }
        $roles = Role::get();
       
        return view('users.edit')->with('user',$user)->with('roles', $roles)->with('config',$this->getConfiguration());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        if(!$this->can('user_update')){
            return redirect()->route('home'); 
        }
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->username = $request->input('username');
        $user->password = $request->input('password');
        $user->email = $request->input('email');

        $actualRoles = $user->roles()->get()->toArray();

        foreach ($actualRoles as $actualRol) {
            $user->roles()->detach($actualRol['id']);
        }
        foreach($request->input('role') as $idRol){
            $user->roles()->attach($idRol);
        }
        $user->save();
        
        
        return redirect()->route('user.show',$user->id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if(!$this->can('user_destroy')){
            return redirect()->route('home'); 
        }
        $user->delete();
        return redirect()->route('user.index')->with('alert', 'Usuario eliminado con éxito.');

    }

    /**
     * Block the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function block(User $user){
        if(!$this->can('user_update')){
            return redirect()->route('home'); 
        }
        $user->active = false;
        $user->save();
        return redirect()->route('user.index');
    }

     /**
     * Unblock the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */   
    public function unblock(User $user){
        if(!$this->can('user_update')){
            return redirect()->route('home'); 
        }
        $user->active = true;
        $user->save();
        return redirect()->route('user.index');
    }
}
