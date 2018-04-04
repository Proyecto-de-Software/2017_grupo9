<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
class SessionController extends Controller
{
    public function loginView(){
    	return view('login');
    }

    public function login(Request $request){
    	
    }
}

?>
