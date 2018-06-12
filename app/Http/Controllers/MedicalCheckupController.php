<?php

namespace App\Http\Controllers;

use App\Patient;
use App\User;
use App\MedicalCheckup;
use Illuminate\Http\Request;
use App\Http\Requests\MedicalCheckupRequest;

class MedicalCheckupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }
    
    /**
     * Display a listing of the resource.
     * @param  \App\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        if(!$this->can('medicalCheckup_index')){
            return redirect()->route('home'); 
        }
        $id = $id;
        $controls = User::join('medical_checkups', function ($join) use ($id){
            $join->on('medical_checkups.user_id', '=', 'users.id')
                ->where('medical_checkups.patient_id', '=', $id);
        })
        ->get();
        return view('medicalCheckups.index', compact('controls'))->with('patient_id',$id)->with('config',$this->getConfiguration());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        if(!$this->can('medicalCheckup_new')){
            return redirect()->route('home'); 
        } 
        return view('medicalCheckups.create')->with('patient_id',$id)->with('config',$this->getConfiguration());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MedicalCheckupRequest $request)
    {
        if(!$this->can('medicalCheckup_new')){
            return redirect()->route('home'); 
        }
        $medicalCheckup = new MedicalCheckup();

        $medicalCheckup->date = $request->date;
        $medicalCheckup->weight = $request->weight;
        $medicalCheckup->complete_vaccines = $request->complete_vaccines;
        $medicalCheckup->complete_vaccines_observation = $request->complete_vaccines_observation;
        $medicalCheckup->correct_maturation = $request->correct_maturation;
        $medicalCheckup->correct_maturation_observation = $request->correct_maturation_observation;
        $medicalCheckup->normal_physical_examination = $request->normal_physical_examination;
        $medicalCheckup->normal_physical_examination_observation = $request->normal_physical_examination_observation;
        $medicalCheckup->pc = $request->pc;
        $medicalCheckup->ppc = $request->ppc;
        $medicalCheckup->height = $request->height;
        $medicalCheckup->food_description = $request->food_description;
        $medicalCheckup->general_observation = $request->general_observation;
        $medicalCheckup->patient_id = $request->patient_id;
        $medicalCheckup->user_id = \Auth::user()->id;

        $medicalCheckup->save();

        return redirect()->route('medicalCheckup.show',$medicalCheckup->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MedicalCheckup  $medicalCheckup
     * @return \Illuminate\Http\Response
     */
    public function show(MedicalCheckup $medicalCheckup)
    {
        if(!$this->can('medicalCheckup_show')){
            return redirect()->route('home'); 
        }
        return view('medicalCheckups.show')->with('control',$medicalCheckup)->with('config',$this->getConfiguration());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MedicalCheckup  $medicalCheckup
     * @return \Illuminate\Http\Response
     */
    public function edit(MedicalCheckup $medicalCheckup)
    {
        if(!$this->can('medicalCheckup_update')){
            return redirect()->route('home'); 
        }
        return view('medicalCheckups.edit')->with('control',$medicalCheckup)->with('patient_id',$medicalCheckup->patient_id)->with('config',$this->getConfiguration());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MedicalCheckup  $medicalCheckup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MedicalCheckup $medicalCheckup)
    {
        if(!$this->can('medicalCheckup_update')){
            return redirect()->route('home'); 
        }
        $medicalCheckup->date = $request->input('date');
        $medicalCheckup->weight = $request->input('weight');
        $medicalCheckup->complete_vaccines = $request->input('complete_vaccines');
        $medicalCheckup->complete_vaccines_observation = $request->input('complete_vaccines_observation');
        $medicalCheckup->correct_maturation = $request->input('correct_maturation');
        $medicalCheckup->correct_maturation_observation = $request->input('correct_maturation_observation');
        $medicalCheckup->normal_physical_examination = $request->input('normal_physical_examination');
        $medicalCheckup->normal_physical_examination_observation = $request->input('normal_physical_examination_observation');
        $medicalCheckup->pc = $request->input('pc');
        $medicalCheckup->ppc = $request->input('ppc');
        $medicalCheckup->height = $request->input('height');
        $medicalCheckup->food_description = $request->input('food_description');
        $medicalCheckup->general_observation = $request->input('general_observation');
        $medicalCheckup->user_id = 2; //Auth::user()->id;

        $medicalCheckup->save();

        return redirect()->route('medicalCheckup.show',$medicalCheckup->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MedicalCheckup  $medicalCheckup
     * @return \Illuminate\Http\Response
     */
    public function destroy(MedicalCheckup $medicalCheckup)
    {
        if(!$this->can('medicalCheckup_destroy')){
            return redirect()->route('home'); 
        }
        $medicalCheckup->delete();
        return redirect('/medicalCheckup/patient/'.$medicalCheckup->patient_id)->with('alert', 'Control eliminado con éxito.');
    }
}
