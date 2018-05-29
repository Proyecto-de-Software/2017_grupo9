<section class="row mx-auto mt-5 ">
	<div class="login col-md-7  mx-auto mt-4 mb-4 pb-5 pt-5 pr-5 pl-5 border rounded ">

		@include('partials.error')
		
		@if(isset($patient))
			@php 
				$title = 'Editar paciente';
				$url = '/patient/'.$patient->id;
				$method = 'put';
				$firstNameValue = $patient->first_name;
				$lastNameValue = $patient->last_name;
				$birthdateValue = $patient->birthdate;
				$genderValue = $patient->gender;
				$typeDocumentValue = $patient->type_document;
				$documentNumberValue = $patient->document_number;
				$healthInsuranceValue = $patient->health_insurance;
				$addressValue = $patient->address;
				$phoneValue = $patient->phone;
			@endphp
		@else
			@php 
				$title = 'Nuevo paciente';
				$url = '/patient';
				$method = 'post';
				$firstNameValue = null;
				$lastNameValue = null;
				$birthdateValue = null;
				$genderValue = null;
				$typeDocumentValue = null;
				$documentNumberValue = null;
				$healthInsuranceValue = null;
				$addressValue = null;
				$phoneValue = null;
			@endphp
		@endif
		
		<h3 class="card-header text-center myHeader"> {{ $title }}</h3>
	
		{!! Form::open(['url' => $url, 'method' => $method]) !!} 
			<div class="form-group row ">
			    {!! Form::label('first_name', 'Nombre',[
					    'class'=>'col-sm-3 mt-3 col-form-label'
					    ]) 
			    !!}
			    {!! Form::text('first_name', $firstNameValue, [
			    	'placeholder' => 'Nombre',
			    	'class' => 'form-control mt-3 col-sm-8'
			    ]) !!}
			</div>
		  	<div class="form-group row ">
			    {!! Form::label('last_name', 'Apellido',[
					    'class'=>'col-sm-3 mt-3 col-form-label'
					    ]) 
				!!}
			    {!! Form::text('last_name', $lastNameValue, array(
			    	'placeholder' => 'Apellido',
			    	'class' => 'form-control mt-3 col-sm-8'
			    )) !!}
		  	</div>
		  	<div class="form-group row">
			    {!! Form::label('birthdate', 'Fecha de nacimiento',[
					    'class'=>'col-sm-3 mt-3 col-form-label'
					    ]) 
				!!}
			    <input type="date" min="2005-01-01" class="form-control mt-3 col-sm-8" id="birthdate" name="birthdate" value="{{ $birthdateValue }}" required>
		  	</div>
		  	<div class="form-group row">
		  		{!! Form::label('gender', 'Género',[
					    'class'=>'col-sm-3 mt-3 col-form-label'
					    ]) 
				!!}
		    	@if($genderValue == 'm')
		    		{!! Form::select('gender', array('m' => 'Masculino', 'f' => 'Femenino'), 'm', ['class'=>'form-control mt-3 col-sm-8']) !!}
	      		@else
	      			{!! Form::select('gender', array('m' => 'Masculino', 'f' => 'Femenino'), 'f', ['class'=>'form-control mt-3 col-sm-8']) !!}
      			@endif
		  	</div>
		  	<div class="form-group row">
		  		{!! Form::label('type_document', 'Tipo de documento',[
					    'class'=>'col-sm-3 mt-3 col-form-label'
					    ]) 
				!!}
				<select class="form-control mt-3 col-sm-8" name="type_document">
					@foreach($typesDocument as $value)
						@if($typeDocumentValue == $value->id)
							<option value="{{ $value->id }}" selected>{{ $value->nombre }}</option>
						@else
							<option value="{{ $value->id }}">{{ $value->nombre }}</option>
						@endif
					@endforeach
				</select>
		  	</div>
		  	<div class="form-group row ">
		  		{!! Form::label('document_number', 'Número de documento',[
					    'class'=>'col-sm-3 mt-3 col-form-label'
					    ]) 
				!!}
			    {!! Form::input('number', 'document_number', $documentNumberValue, array(
			    	'placeholder' => 'Número de documento',
			    	'class' => 'form-control mt-3 col-sm-8'
			    )) !!}
			</div>
			<div class="form-group row">
		  		{!! Form::label('health_insurance', 'Obra social',[
				    'class'=>'col-sm-3 mt-3 col-form-label'
				    ]) 
				!!}
				<select class="form-control mt-3 col-sm-8" name="health_insurance">
					@if($healthInsuranceValue == null)
						<option value="" selected>Ingrese obra social</option>
					@else
						<option value="">Ingrese obra social</option>
					@endif
					@foreach($healthsInsurance as $value)
						@if($healthInsuranceValue == $value->id)
							<option value="{{ $value->id }}" selected>{{ $value->nombre }}</option>
						@else
							<option value="{{ $value->id }}">{{ $value->nombre }}</option>
						@endif
					@endforeach
				</select>
		  	</div>
			<div class="form-group row ">
		  		{!! Form::label('address', 'Dirección',[
					    'class'=>'col-sm-3 mt-3 col-form-label'
					    ]) 
				!!}
			    {!! Form::text('address', $addressValue, array(
			    	'placeholder' => 'Dirección',
			    	'class' => 'form-control mt-3 col-sm-8'
			    )) !!}
			</div>
			<div class="form-group row ">
				{!! Form::label('phone', 'Teléfono',[
					    'class'=>'col-sm-3 mt-3 col-form-label'
					    ]) 
				!!}
			    {!! Form::input('number', 'phone', $phoneValue, array(
			    	'placeholder' => 'Teléfono',
			    	'class' => 'form-control mt-3 col-sm-8'
			    )) !!}
			</div>
			@if(isset($patient))
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