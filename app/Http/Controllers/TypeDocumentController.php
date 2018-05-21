<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TypeDocumentController extends Controller
{
	 public function get(){
        return GuzzleAppController::get('tipo-documento');
    }

    public function getHealthInsurance($id){
        return GuzzleAppController::get('tipo-documento','/'.$id);
    }
}
