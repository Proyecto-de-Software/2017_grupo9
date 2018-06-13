<?php

namespace App\Http\Controllers;

use App\Patient;
use App\DemographicData;
use Illuminate\Http\Request;
use App\Http\Requests\PatientRequest;
use App\Http\Controllers\HealthInsuranceController;


class PatientController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');

    }
        
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!$this->can('patient_index')){
            return redirect()->route('home'); 
        }
        if($request->get('type_document') != null){
            $typeDocument = $request->get('type_document');
            $patients = Patient::document($request->get('type_document'), $request->get('document_number'))->orderBy('last_name', 'ASC')->paginate($this->getConfiguration()->elements_for_page);
        }
        else{
            $typeDocument = null;
            $patients = Patient::name($request->get('name'))->orderBy('last_name', 'ASC')->paginate($this->getConfiguration()->elements_for_page);
        }
        $typesDocument = TypeDocumentController::get();


        return view('patients.index', compact('patients'))->with('typesDocument', $typesDocument)->with('typeDocument', $typeDocument)->with('config',$this->getConfiguration());

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!$this->can('patient_new')){
            return redirect()->route('home'); 
        }
        $healthsInsurance = HealthInsuranceController::get();
        $typesDocument = TypeDocumentController::get();
        return view('patients.create')->with('healthsInsurance',$healthsInsurance)->with('typesDocument',$typesDocument)->with('config',$this->getConfiguration());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PatientRequest $request)
    {
        if(!$this->can('patient_new')){
            return redirect()->route('home'); 
        }
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
        if(!$this->can('patient_show')){
            return redirect()->route('home'); 
        }
        $healthInsurance = null;
        $typeDocument = TypeDocumentController::find($patient->type_document);
        if($patient->health_insurance != null){
            $healthInsurance = HealthInsuranceController::find($patient->health_insurance);
        }
        return view('patients.show')->with('patient',$patient)->with('healthInsurance',$healthInsurance)->with('typeDocument',$typeDocument)->with('config',$this->getConfiguration());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function edit(Patient $patient)
    {
        if(!$this->can('patient_update')){
            return redirect()->route('home'); 
        }
        $healthsInsurance = HealthInsuranceController::get();
        $typesDocument = TypeDocumentController::get();
        return view('patients.edit')->with('patient',$patient)->with('healthsInsurance',$healthsInsurance)->with('typesDocument',$typesDocument)->with('config',$this->getConfiguration());
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
        if(!$this->can('patient_update')){
            return redirect()->route('home'); 
        }
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
        if(!$this->can('patient_destroy')){
            return redirect()->route('home'); 
        }
        $patient->delete();
        return redirect()->route('patient.index')->with('alert', 'Paciente eliminado con éxito.');
    }
}
