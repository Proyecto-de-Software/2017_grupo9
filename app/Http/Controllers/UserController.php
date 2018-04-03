<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Rol;
use App\UserRol;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::get();
        return view('users.index')->with('users', $users);
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    }
    public function create()
    {
        $rols = Rol::get();
        return view('users.create')->with('rols',$rols);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $user = User::create(
            [
                'first_name' => $request->input('nombre'),
                'last_name' => $request->input('apellido'),
                'username' => $request->input('usuario'),
                'password' => $request->input('password'),
                'active' => true,
                'email' => $request->input('email')
            ]
        );
    
      
        foreach($request->input('rol') as $idRol){
            $userRol = new UserRol();
            $userRol->user_id = $user->id;
            $userRol->rol_id = $idRol;
            $userRol->save();
        }
       
        return redirect()->route('user.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rols = Rol::get();
        $user = User::find($id);
        
        return view('users.edit')->with('user',$user)->with('rols', $rols);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        $user->first_name = $request->input('nombre');
        $user->last_name = $request->input('apellido');
        $user->username = $request->input('usuario');
        $user->password = $request->input('password');
        $user->email = $request->input('email');

       

        $user->save();
        return redirect()->route('user.index');

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
