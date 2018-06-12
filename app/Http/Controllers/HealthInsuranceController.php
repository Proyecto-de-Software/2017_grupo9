<?php

namespace App\Http\Controllers;

use App\HealthInsurance;
use Illuminate\Http\Request;

class HealthInsuranceController extends Controller
{
	public function __construct()
    {
      $this->middleware('auth');

    }
    public static function get(){
        return GuzzleAppController::get('obra-social');
    }

    public static function find($id){
        return GuzzleAppController::get('obra-social','/'.$id);
    }
}
