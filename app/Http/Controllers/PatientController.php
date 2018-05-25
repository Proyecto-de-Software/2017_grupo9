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
        $patients = Patient::orderBy('last_name', 'ASC')->paginate(5);
        return view('patients.index', compact('patients'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $healthsInsurance = HealthInsuranceController::get();
        $typesDocument = TypeDocumentController::get();
        return view('patients.create')->with('healthsInsurance',$healthsInsurance)->with('typesDocument',$typesDocument);
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
    public function show(Patient $patient)
    {
        $healthInsurance = HealthInsuranceController::find($patient->health_insurance);
        $typeDocument = TypeDocumentController::find($patient->type_document);
        return view('patients.show')->with('patient',$patient)->with('healthInsurance',$healthInsurance)->with('typeDocument',$typeDocument);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function edit(Patient $patient)
    {
        $healthsInsurance = HealthInsuranceController::get();
        $typesDocument = TypeDocumentController::get();
        return view('patients.edit')->with('patient',$patient)->with('healthsInsurance',$healthsInsurance)->with('typesDocument',$typesDocument);
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
        $patient->first_name = $request->input('first_name');
        $patient->last_name = $request->input('last_name');
        $patient->address = $request->input('address');
        $patient->phone = $request->input('phone');
        $patient->birthdate = $request->input('birthdate');
        $patient->gender = $request->input('gender');
        $patient->type_document = $request->input('type_document');
        $patient->document_number = $request->input('document_number');
        $patient->health_insurance = $request->input('health_insurance');

        $patient->save();
        
        return redirect()->route('patient.show',$patient);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function destroy(Patient $patient)
    {
        $patient->delete();
        return redirect()->route('patient.index');
    }
}
