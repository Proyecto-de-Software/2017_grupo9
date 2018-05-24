<section class="row mx-auto mt-5 ">
	<div class="login col-md-7  mx-auto mt-4 mb-4 pb-5 pt-5 pr-5 pl-5 border rounded ">
	@if(isset($demographicData))
		@php
			$url = '/demographicData/'.$demographicData->id;
			$method = 'put';
			$refrigeratorValue = demographicData.refrigerator;
			$electricityValue = demographicData.electricity;
			$petValue = demographicData.pet;
			$typeLivingPlaceValue = demographicData.typeLivingPlace;
			$typeHeatingValue = demographicData.typeHeating;
			$typeWaterValue = demographicData.typeWater;
			$title = 'Editar datos demográficos';
		@endphp
	@else
		@php
			$url = '/demographicData';
			$method = 'post';
			$refrigeratorValue = null;
			$electricityValue = null;
			$petValue = null;
			$typeLivingPlaceValue = null;
			$typeHeatingValue = null;
			$typeWaterValue = null;
			$title = 'Agregar datos demográficos';
		@endphp
	@endif
		<h3 class="card-header text-center myHeader">{{ $title }} </h3><br>
		
		{!! Form::open(['url' => $url, 'method' => $method]) !!}
		  	<div class="form-group row ">
			    {!! Form::label('refrigerator', 'Heladera',[
					    'class'=>'col-sm-3 mt-3 col-form-label'
					    ]) 
			    !!}
			    @if($refrigeratorValue == 1)
		    		{!! Form::select('refrigerator', array('1' => 'Si', '0' => 'No'), '1', ['class'=>'form-control mt-3 col-sm-8']) !!}
	      		@else
	      			{!! Form::select('refrigerator', array('1' => 'Si', '0' => 'No'), '0', ['class'=>'form-control mt-3 col-sm-8']) !!}
      			@endif
			</div>
			<div class="form-group row ">
			    {!! Form::label('electricity', 'Electricidad',[
					    'class'=>'col-sm-3 mt-3 col-form-label'
					    ]) 
			    !!}
			    @if($electricityValue == 1)
		    		{!! Form::select('electricity', array('1' => 'Si', '0' => 'No'), '1', ['class'=>'form-control mt-3 col-sm-8']) !!}
	      		@else
	      			{!! Form::select('electricity', array('1' => 'Si', '0' => 'No'), '0', ['class'=>'form-control mt-3 col-sm-8']) !!}
      			@endif
			</div>
			<div class="form-group row ">
			    {!! Form::label('pet', 'Mascota',[
					    'class'=>'col-sm-3 mt-3 col-form-label'
					    ]) 
			    !!}
			    @if($petValue == 1)
		    		{!! Form::select('pet', array('1' => 'Si', '0' => 'No'), '1', ['class'=>'form-control mt-3 col-sm-8']) !!}
	      		@else
	      			{!! Form::select('pet', array('1' => 'Si', '0' => 'No'), '0', ['class'=>'form-control mt-3 col-sm-8']) !!}
      			@endif
			</div>
		  	<div class="form-group row">
			    {!! Form::label('typeLivingPlace', 'Tipo de vivienda',[
					    'class'=>'col-sm-3 mt-3 col-form-label'
					    ]) 
			    !!}
			    	<select name="typeLivingPlace_id" class="form-control mt-3 col-sm-8">
				    	@foreach($typesLivingPlace as $value)
				    		@if($typeLivingPlaceValue == $value->id)
				    			<option value="{{ $value->id }}" selected>{{ $value->nombre }}</option>
				    		@else
				    			<option value="{{ $value->id }}">{{ $value->nombre }}</option>
				    		@endif
				    	@endforeach
			    	</select>
		  	</div>
		  	<div class="form-group row">
			    {!! Form::label('typeHeating', 'Tipo de calefaccion',[
					    'class'=>'col-sm-3 mt-3 col-form-label'
					    ]) 
			    !!}
			    	<select name="typeHeating_id" class="form-control mt-3 col-sm-8">
				    	@foreach($typesHeating as $value)
				    		@if($typeHeatingValue == $value->id)
				    			<option value="{{ $value->id }}" selected>{{ $value->nombre }}</option>
				    		@else
				    			<option value="{{ $value->id }}">{{ $value->nombre }}</option>
				    		@endif
				    	@endforeach
			    	</select>
		  	</div>
		  	<div class="form-group row">
			    {!! Form::label('typeWater', 'Tipo de agua',[
					    'class'=>'col-sm-3 mt-3 col-form-label'
					    ]) 
			    !!}
			    	<select name="typeWater_id" class="form-control mt-3 col-sm-8">
				    	@foreach($typesWater as $value)
				    		@if($typeWaterValue == $value->id)
				    			<option value="{{ $value->id }}" selected>{{ $value->nombre }}</option>
				    		@else
				    			<option value="{{ $value->id }}">{{ $value->nombre }}</option>
				    		@endif
				    	@endforeach
			    	</select>
		  	</div>
		  	{!! Form::hidden('patient_id', $patient_id) !!}
		  	<button onclick="return confirm('Seguro?')" type="submit" class="btn btn-outline-success  btn-own-info">{{ $title }}</button>
		{!! Form::close() !!}
	</div>
</section>