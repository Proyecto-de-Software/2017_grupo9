<?php

namespace App\Http\Controllers;

use App\Patient;
use App\MedicalCheckup;
use Illuminate\Http\Request;
use App\Http\Requests\MedicalCheckupRequest;

class MedicalCheckupController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param  \App\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $controls = MedicalCheckup::where('patient_id', $id)->get();
        return view('medicalCheckups.index', compact('controls'))->with('patient_id',$id);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        return view('medicalCheckups.create')->with('patient_id',$id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MedicalCheckupRequest $medicalCheckup)
    {
        $medicalCheckup = new MedicalCheckup();

        $medicalCheckup->date = $request->date;
        $medicalCheckup->weight = $request->weight;
        $medicalCheckup->complete_vaccines = $request->complete_vaccines;
        $medicalCheckup->complete_vaccines_observation = $request->complete_vaccines_observation;
        $medicalCheckup->correct_maduration = $request->correct_maduration;
        $medicalCheckup->correct_maturation_observation = $request->correct_maduration_observation;
        $medicalCheckup->normal_physical_examination = $request->normal_physical_examination;
        $medicalCheckup->normal_physical_examination_observation = $request->normal_physical_examination_observation;
        $medicalCheckup->pc = $request->pc;
        $medicalCheckup->ppc = $request->ppc;
        $medicalCheckup->height = $request->height;
        $medicalCheckup->food_description = $request->food_description;
        $medicalCheckup->general_observation = $request->general_observation;
        $medicalCheckup->patient_id = $request->patient_id;
        $medicalCheckup->user_id = Auth::user()->id;

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
        return view('medicalCheckups.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MedicalCheckup  $medicalCheckup
     * @return \Illuminate\Http\Response
     */
    public function edit(MedicalCheckup $medicalCheckup)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MedicalCheckup  $medicalCheckup
     * @return \Illuminate\Http\Response
     */
    public function destroy(MedicalCheckup $medicalCheckup)
    {
        //
    }
}
