<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Configuration;
use App\Http\Controllers\Controller;
use App\Http\Requests\ConfigRequest;
class ConfigController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }    
    
    public function show(Configuration $configuration)
    {	
    	
    	return view('configurations.show', ['config' => $configuration]);
    }

    public function store(ConfigRequest $request, Configuration $configuration)
    {
    	$configuration->title = $request->get('title');
    	$configuration->email_contact = $request->get('email_contact');
    	$configuration->elements_for_page = $request->get('elements_for_page');
    	$configuration->state = $request->get('state');
    	$configuration->hospital_description = $request->get('hospital_description');
    	$configuration->guard_description = $request->get('guard_description');
    	$configuration->specialties_description = $request->get('specialties_description');
    	$configuration->save();
    	return redirect("/config/1");
    }
}
