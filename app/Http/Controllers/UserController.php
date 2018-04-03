<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Rol;
use App\UserRol;

class UserController extends Controller
{
    
    public function index()
    {
        $users = User::get();
        return view('users.index')->with('users', $users);
    }

    public function create()
    {
        $rols = Rol::get();
        return view('users.create')->with('rols',$rols);
    }

    public function store(Request $request)
    {   
        $user = new User();

        $user->first_name = $request->input('nombre');
        $user->last_name = $request->input('apellido');
        $user->active = true;
        $user->username = $request->input('usuario');
        $user->password = $request->input('password');
        $user->email = $request->input('email');
        $user->save();
        foreach($request->input('rol') as $idRol){
            $user->rols()->attach($idRol);
        }
        $user->save();
       
        return redirect()->route('user.show',$user->id);
    }

    
    public function show($id)
    {
        $user = User::find($id);
        $rols = $user->rols()->get();
      
        return view('users.show')->with('user',$user)->with('rols',$rols);
    }

    public function edit($id)
    {
        $rols = Rol::get();
        $user = User::find($id);
        $userRols = $user->rols()->get()->toArray();
        return view('users.edit')->with('user',$user)->with('rols', $rols)->with('userRols',$userRols);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        $user->first_name = $request->input('nombre');
        $user->last_name = $request->input('apellido');
        $user->username = $request->input('usuario');
        $user->password = $request->input('password');
        $user->email = $request->input('email');
        $newRols = $request->input('rol');
        if(!isset($newRols)){
            $newRols = array();
        }
        
        $actualRols = $user->rols()->get()->toArray();
        foreach ($newRols as $idRol){
            foreach ($actualRols as $actualRol) {
                $ok = ! in_array($idRol, $actualRol);
                if($ok){
                    $user->rols()->attach($idRol);
                }
                if(in_array($actualRol['id'], $newRols)){
                    $user->rols()->detach($idRol);
                }
            }
            
        }
        $user->save();
        
        return redirect()->route('user.show',$id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
