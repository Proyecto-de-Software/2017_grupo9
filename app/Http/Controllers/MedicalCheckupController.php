<?php

namespace App\Http\Controllers;

use App\MedicalCheckup;
use Illuminate\Http\Request;
use App\Http\Requests\MedicalCheckupRequest;

class MedicalCheckupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $controls = MedicalCheckup::where('patient_id', $id)->get();
        return view('medicalCheckups.partials.medicalCheckupList')->with('controls',$controls);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('medicalCheckups.partials.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MedicalCheckup  $medicalCheckup
     * @return \Illuminate\Http\Response
     */
    public function show(MedicalCheckup $medicalCheckup)
    {
        return view('medicalCheckups.partials.show');
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
