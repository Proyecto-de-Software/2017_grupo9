<?php

namespace App\Http\Controllers;

use App\Patient;
use App\DemographicData;
use Illuminate\Http\Request;
use App\Http\Requests\PatientRequest;
use App\Http\Controllers\HealthInsuranceController;


class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $patients = Patient::get();
        return view('patients.index')->with('patients',$patients);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $healthInsurance = new HealthInsuranceController();
        $healthsInsurance = $healthInsurance->get();
        return view('patients.create')->with('healthsInsurance',$healthsInsurance);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PatientRequest $request)
    {
        $patient = new Patient();

        $patient->first_name = $request->first_name;
        $patient->last_name = $request->last_name;
        $patient->address = $request->address;
        $patient->phone = $request->phone;
        $patient->birthdate  = $request->birthdate;
        $patient->gender = $request->gender;
        $patient->type_document = $request->type_document;
        $patient->document_number = $request->document_number;
        $patient->health_insurance = $request->health_insurance;

        $patient->save();

        return redirect()->route('patient.show',$patient->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $patient = Patient::find($id);
        DemographicData::getPatientId($id);
        return view('patients.show')->with('patient',$patient);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function edit(Patient $patient)
    {
        return view('patients.edit')->with('patient',$patient);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function update(PatientRequest $request, Patient $patient)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function destroy(Patient $patient)
    {
        $patient = Patient::find($id);
        $patient->delete();
        return redirect()->route('patient.index');
    }
}
