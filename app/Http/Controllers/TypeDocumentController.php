<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TypeDocumentController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');

    }
	 public static function get(){
        return GuzzleAppController::get('tipo-documento');
    }

    public static function find($id){
        return GuzzleAppController::get('tipo-documento','/'.$id);
    }
}
