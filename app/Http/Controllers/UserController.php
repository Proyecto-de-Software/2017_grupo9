<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    
    public function index()
    {
        $users = User::orderBy('id', 'ASC')->paginate();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::get();
        return view('users.create')->with('roles',$roles);
    }

    public function store(UserRequest $request)
    {   
        $user = new User();

        $user->first_name = $request->input('nombre');
        $user->last_name = $request->input('apellido');
        $user->active = true;
        $user->username = $request->input('usuario');
        $user->password = $request->input('password');
        $user->email = $request->input('email');
        $user->save();
        foreach($request->input('role') as $idRole){
            $user->roles()->attach($idRole);
        }
        $user->save();
       
        return redirect()->route('user.show',$user->id);
    }

    
    public function show($id)
    {
        $user = User::find($id);
        $roles = $user->roles()->get()->map(function($rol,$key){
                                             return $rol->name;
                                             })->toArray();
        
        return view('users.show')->with('user',$user)->with('roles',$roles);
    }

    public function edit($id)
    {
        $roles = Role::get();
        $user = User::find($id);
        $userRole = $user->roles()->get()->map(function($role,$key){
                                                return $role->id; 
                                            })->toArray();
        
        return view('users.edit')->with('user',$user)->with('roles', $roles)->with('userRole',$userRole);
    }

    public function update(UserRequest $request, $id)
    {
        $user = User::find($id);

        $user->first_name = $request->input('nombre');
        $user->last_name = $request->input('apellido');
        $user->username = $request->input('usuario');
        $user->password = $request->input('password');
        $user->email = $request->input('email');
        

        $actualRole = $user->role()->get()->toArray();
        foreach ($actualrole as $actualRol) {
            $user->role()->detach($actualRole['id']);
        }
        foreach($request->input('role') as $e){
            $user->role()->attach($idRole);
        }
        $user->save();
        
        return redirect()->route('user.show',$id);

    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return "hola";

    }

    public function block($id){
        $user = User::find($id);
        $user->active = false;
        $user->save();
        return redirect()->route('user.index');
    }
    public function unblock($id){
        $user = User::find($id);
        $user->active = true;
        $user->save();
        return redirect()->route('user.index');
    }
}
