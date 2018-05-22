<?php

namespace App\Http\Controllers;

use App\DemographicData;
use Illuminate\Http\Request;
use App\Http\Requests\DemographicDataRequest;

class DemographicDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DemographicDataRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DemographicData  $demographicData
     * @return \Illuminate\Http\Response
     */
    public function show(DemographicData $demographicData)
    {
        $types = getAllTypes();
        $typeHeating = getTypeHeating($demographicData->typeHeating_id);
        $typeWater = getTypeWater($demographicData->typeWater_id);
        $typeLivingPlace = getTypeLivingPlace($demographicData->typeLivingPlace_id); 
        $typeDocument = TypeDocumentController::find($patient->type_document);
        return view('patients.show')->with('patient',$patient)->with('typeHeating',$typeHeating)->with('typeWater',$typeWater)->with('typeLivingPlace',$typeLivingPlace);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DemographicData  $demographicData
     * @return \Illuminate\Http\Response
     */
    public function edit(DemographicData $demographicData)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DemographicData  $demographicData
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DemographicDataRequest $demographicData)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DemographicData  $demographicData
     * @return \Illuminate\Http\Response
     */
    public function destroy(DemographicData $demographicData)
    {
        //
    }

    public function getAllTypes(){
        $types = [];
        $types['typeLivingPlace'] = GuzzleAppController::get('tipo-vivienda');
        $types['typeWater'] = GuzzleAppController::get('tipo-agua');
        $types['typeHeating'] = GuzzleAppController::get('tipo-calefaccion');
        
        return $types;
    }

    public function getTypeLivingPlace($id){
        return GuzzleAppController::get('tipo-vivienda',$id);
    }

    public function getTypeHeating($id){
        return GuzzleAppController::get('tipo-calefaccion',$id);
    }

    public function getTypeWater($id){
        return GuzzleAppController::get('tipo-agua',$id);
    }
}
