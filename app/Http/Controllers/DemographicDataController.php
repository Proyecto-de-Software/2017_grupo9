<?php

namespace App\Http\Controllers;

use App\DemographicData;
use App\Patient;
use Illuminate\Http\Request;
use App\Http\Requests\DemographicDataRequest;

class DemographicDataController extends Controller
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
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        if(!$this->can('demographicData_new')){
            return redirect()->route('home'); 
        }
        $types = $this->getAllTypes();
        return view('demographicDatas.create')->with('patient_id',$id)->with('typesLivingPlace',$types['typesLivingPlace'])->with('typesHeating',$types['typesHeating'])->with('typesWater',$types['typesWater'])->with('config',$this->getConfiguration());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DemographicDataRequest $request)
    {
        if(!$this->can('demographicData_new')){
            return redirect()->route('home'); 
        }
        
        $demographicData = new DemographicData();

        $demographicData->electricity = $request->electricity;
        $demographicData->pet = $request->pet;
        $demographicData->refrigerator = $request->refrigerator;
        $demographicData->typeLivingPlace_id = $request->typeLivingPlace_id;
        $demographicData->typeHeating_id  = $request->typeHeating_id;
        $demographicData->typeWater_id = $request->typeWater_id;
        $demographicData->patient_id = $request->patient_id;

        $demographicData->save();


        $patient = Patient::find($request->patient_id);
        $patient->demographic_data_id = $demographicData->id;
        $patient->save();

        return redirect()->route('demographicData.show',$demographicData->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DemographicData  $demographicData
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(!$this->can('demographicData_show')){
            return redirect()->route('home'); 
        }
        $demographicData = DemographicData::find($id);
        $typeHeating = $this->getTypeHeating($demographicData->typeHeating_id);
        $typeWater = $this->getTypeWater($demographicData->typeWater_id);
        $typeLivingPlace = $this->getTypeLivingPlace($demographicData->typeLivingPlace_id);
        return view('demographicDatas.show')->with('demographicData',$demographicData)->with('typeHeating',$typeHeating)->with('typeWater',$typeWater)->with('typeLivingPlace',$typeLivingPlace)->with('config',$this->getConfiguration());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DemographicData  $demographicData
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!$this->can('demographicData_update')){
            return redirect()->route('home'); 
        }
        $demographicData = DemographicData::find($id);
        $types = $this->getAllTypes();
        $typeHeating = $this->getTypeHeating($demographicData->typeHeating_id);
        $typeWater = $this->getTypeWater($demographicData->typeWater_id);
        $typeLivingPlace = $this->getTypeLivingPlace($demographicData->typeLivingPlace_id);
        return view('demographicDatas.edit')->with('demographicData',$demographicData)->with('patient_id',$id)->with('typesLivingPlace',$types['typesLivingPlace'])->with('typesHeating',$types['typesHeating'])->with('typesWater',$types['typesWater'])->with('config',$this->getConfiguration());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DemographicData  $demographicData
     * @return \Illuminate\Http\Response
     */
    public function update(DemographicDataRequest $request, $id)
    {
        if(!$this->can('demographicData_update')){
            return redirect()->route('home'); 
        }
        $demographicData = DemographicData::find($id);
        $demographicData->electricity = $request->input('electricity');
        $demographicData->pet = $request->input('pet');
        $demographicData->refrigerator = $request->input('refrigerator');
        $demographicData->patient_id = $request->input('patient_id');
        $demographicData->typeLivingPlace_id = $request->input('typeLivingPlace_id');
        $demographicData->typeHeating_id = $request->input('typeHeating_id');
        $demographicData->typeWater_id = $request->input('typeWater_id');

        $demographicData->save();
        
        return redirect()->route('demographicData.show',$demographicData);
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
        $types['typesLivingPlace'] = GuzzleAppController::get('tipo-vivienda');
        $types['typesWater'] = GuzzleAppController::get('tipo-agua');
        $types['typesHeating'] = GuzzleAppController::get('tipo-calefaccion');
        
        return $types;
    }

    public function getTypeLivingPlace($id){
        return GuzzleAppController::get('tipo-vivienda','/'.$id);
    }

    public function getTypeHeating($id){
        return GuzzleAppController::get('tipo-calefaccion','/'.$id);
    }

    public function getTypeWater($id){
        return GuzzleAppController::get('tipo-agua','/'.$id);
    }
}
