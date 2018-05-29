<section class="row mx-auto mt-5 ">
	<div class="login col-md-10  mx-auto mt-4 mb-4 pb-5 pt-5 pr-5 pl-5 border rounded ">

		@include('partials.error')

		@if(isset($control))
			@php
				$title = 'Editar control';
				$url = '/medicalCheckup/'.$control->id;
				$method = 'put';
				{{-- $ageValue = $age; --}}
				$weightValue = $control->weight;
				$heightValue = $control->height;
				$completeVaccinesValue  = $control->complete_vaccines;
				$completeVaccinesObservationValue = $control->complete_vaccines_observation;
				$correctMaturationValue = $control->correct_maturation;
				$correctMaturationObservationValue = $control->correct_maturation_observation;
				$normalPhysicalExaminationValue = $control->normal_physical_examination;
				$normalPhysicalExaminationObservationValue = $control->normal_physical_examination_observation;
				$pcValue = $control->pc;
				$ppcValue = $control->ppc;
				$foodDescriptionValue = $control->food_description;
				$generalObservationValue = $control->general_observation;
			@endphp
		@else
			@php
				$title = 'Nuevo control';
				$url = '/medicalCheckup';
				$method = 'post';
				$ageValue = null;
				$weightValue = null;
				$heightValue = null;
				$completeVaccinesValue = true;
				$completeVaccinesObservationValue = null;
				$correctMaturationValue = true;
				$correctMaturationObservationValue = null;
				$normalPhysicalExaminationValue = true;
				$normalPhysicalExaminationObservationValue = null ;
				$pcValue = null;
				$ppcValue = null;
				$foodDescriptionValue = null;
				$generalObservationValue = null;
			@endphp
		@endif
		
		<h3 class="card-header text-center myHeader"> {{ $title }}</h3>
	
		{!! Form::open(['url' => $url, 'method' => $method]) !!} 
			<div class="form-group row mt-3">
			   {!! Form::label('date', 'Fecha actual',[
					    'class'=>'col-sm-3 mt-3 col-form-label'
					    ]) 
				!!}
			    <input type="text" readonly class="text-center form-control col-sm-2" id="date" name="date" value='{{ date("Y-m-d") }}'>
		 	</div>
		 	<div class="form-group row ">
			    {!! Form::label('weight', 'Peso',[
					    'class'=>'col-sm-3 mt-3 col-form-label'
					    ]) 
			    !!}
			    {!! Form::input('number', 'weight', $weightValue, [
			    	'placeholder' => 'Peso en kg',
			    	'class' => 'form-control mt-3 col-sm-8',
			    	'required' => true
			    ]) !!}
			</div>
			<div class="form-group row ">
			    {!! Form::label('complete_vaccines', 'Vacunas completas',[
					    'class'=>'col-sm-3 mt-3 col-form-label'
					    ]) 
			    !!}
			    @if($completeVaccinesValue == 1)
		    		{!! Form::select('complete_vaccines', array('1' => 'Si', '0' => 'No'), '1', ['class'=>'form-control mt-3 col-sm-8']) !!}
	      		@else
	      			{!! Form::select('complete_vaccines', array('1' => 'Si', '0' => 'No'), '0', ['class'=>'form-control mt-3 col-sm-8']) !!}
      			@endif
			</div>
			<div class="form-group row ">
			    {!! Form::label('complete_vaccines_observation', 'Observaciones vacunas',[
					    'class'=>'col-sm-3 mt-3 col-form-label'
					    ]) 
			    !!}
			    {!! Form::text('complete_vaccines_observation', $completeVaccinesObservationValue, [
			    	'placeholder' => 'Observaciones vacunas',
			    	'class' => 'form-control mt-3 col-sm-8',
			    	'required' => true
			    ]) !!}
			</div>
			<div class="form-group row ">
			    {!! Form::label('correct_maturation', 'Maduracion acorde',[
					    'class'=>'col-sm-3 mt-3 col-form-label'
					    ]) 
			    !!}
			    @if($correctMaturationValue == 1)
		    		{!! Form::select('correct_maturation', array('1' => 'Si', '0' => 'No'), '1', ['class'=>'form-control mt-3 col-sm-8']) !!}
	      		@else
	      			{!! Form::select('correct_maturation', array('1' => 'Si', '0' => 'No'), '0', ['class'=>'form-control mt-3 col-sm-8']) !!}
      			@endif
			</div>
			<div class="form-group row ">
			    {!! Form::label('correct_maturation_observation', 'Observaciones maduracion',[
					    'class'=>'col-sm-3 mt-3 col-form-label'
					    ]) 
			    !!}
			    {!! Form::text('correct_maturation_observation', $correctMaturationObservationValue, [
			    	'placeholder' => 'Observaciones maduracion',
			    	'class' => 'form-control mt-3 col-sm-8',
			    	'required' => true
			    ]) !!}
			</div>
			<div class="form-group row ">
			    {!! Form::label('normal_physical_examination', 'Examen fisico normal',[
					    'class'=>'col-sm-3 mt-3 col-form-label'
					    ]) 
			    !!}
			    @if($normalPhysicalExaminationValue == 1)
		    		{!! Form::select('normal_physical_examination', array('1' => 'Si', '0' => 'No'), '1', ['class'=>'form-control mt-3 col-sm-8']) !!}
	      		@else
	      			{!! Form::select('normal_physical_examination', array('1' => 'Si', '0' => 'No'), '0', ['class'=>'form-control mt-3 col-sm-8']) !!}
      			@endif
      		</div>
			<div class="form-group row ">
			    {!! Form::label('normal_physical_examination_observation', 'Observaciones examen fisico',[
					    'class'=>'col-sm-3 mt-3 col-form-label'
					    ]) 
			    !!}
			    {!! Form::text('normal_physical_examination_observation', $normalPhysicalExaminationObservationValue, [
			    	'placeholder' => 'Observaciones examen fisico',
			    	'class' => 'form-control mt-3 col-sm-8',
			    	'required' => true
			    ]) !!}
			</div>
			<div class="form-group row ">
			    {!! Form::label('pc', 'pc',[
					    'class'=>'col-sm-3 mt-3 col-form-label'
					    ]) 
			    !!}
			    {!! Form::input('number', 'pc', $pcValue, [
			    	'placeholder' => 'pc',
			    	'class' => 'form-control mt-3 col-sm-8'
			    ]) !!}
			</div>
			<div class="form-group row ">
			    {!! Form::label('ppc', 'ppc',[
					    'class'=>'col-sm-3 mt-3 col-form-label'
					    ]) 
			    !!}
			    {!! Form::input('number', 'ppc', $ppcValue, [
			    	'placeholder' => 'ppc',
			    	'class' => 'form-control mt-3 col-sm-8'
			    ]) !!}
			</div>
			<div class="form-group row ">
			    {!! Form::label('food_description', 'Descripcion de alimentacion',[
					    'class'=>'col-sm-3 mt-3 col-form-label'
					    ]) 
			    !!}
			    {!! Form::text('food_description', $foodDescriptionValue, [
			    	'placeholder' => 'Descripcion de alimentacion',
			    	'class' => 'form-control mt-3 col-sm-8'
			    ]) !!}
			</div>
			<div class="form-group row ">
			    {!! Form::label('height', 'Talla',[
					    'class'=>'col-sm-3 mt-3 col-form-label'
					    ]) 
			    !!}
			    {!! Form::input('number', 'height', $heightValue, [
			    	'placeholder' => 'Talla',
			    	'class' => 'form-control mt-3 col-sm-8'
			    ]) !!}
			</div>
			<div class="form-group row ">
			    {!! Form::label('general_observation', ' Observaciones generales',[
					    'class'=>'col-sm-3 mt-3 col-form-label'
					    ]) 
			    !!}
			    {!! Form::text('general_observation', $generalObservationValue, [
			    	'placeholder' => ' Observaciones generales',
			    	'class' => 'form-control mt-3 col-sm-8'
			    ]) !!}
			</div>		
			{!! Form::hidden('patient_id', $patient_id) !!}
			@if(isset($control))
				<div class="text-center">
					<button type="submit" class="btn btn-outline-success btn-own-info">Editar</button>
				</div>	
			@else
				<div class="text-center">
					<button type="submit" class="btn btn-outline-success btn-own-info">Agregar</button>
				</div>	
			@endif
		{!! Form::close() !!}
	</div>
</section>