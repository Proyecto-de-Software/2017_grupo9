<section class="row mx-auto mt-5 ">
	<div class="login col-md-7  mx-auto mt-4 mb-4 pb-5 pt-5 pr-5 pl-5 border rounded ">

		@include('partials.error')
		
		@if(isset($patient))
			@php 
				$title = 'Editar paciente';
				$firstNameValue = 'value='.$patient->first_name;
				$lastNameValue = 'value='.$patient->last_name;
				$birthdateValue ='value='.$patient->birthday;
				$genderValue = 'value='.$patient->gender;
				$typeDocumentValue = 'value='.$patient->type_document;
				$documentNumberValue = 'value='.$patient->document_number;
				$addressValue = 'value='.$patient->address;
				$phoneValue = 'value='.$patient->phone;
			@endphp
		@else
			@php 
				$title = 'Nuevo paciente';
				$firstNameValue = null;
				$lastNameValue = null;
				$birthdateValue = null;
				$genderValue = null;
				$typeDocumentValue = null;
				$documentNumberValue = null;
				$addressValue = null;
				$phoneValue = null;
			@endphp
		@endif
		
		<h3 class="card-header text-center myHeader"> {{ $title }}</h3>
		{!! Form::open(['url' => '/patient', 'method' => 'post']) !!}
	
			<div class="form-group row ">
			    <label for="first_name"  class="col-sm-3 mt-3 col-form-label">Nombre</label>
			    {!! Form::text('first_name', $firstNameValue, array(
			    	'placeholder' => 'Nombre',
			    	'class' => 'form-control mt-3 col-sm-8'
			    )) !!}
			</div>
		  	<div class="form-group row ">
			    <label for="last_name" class="col-sm-3 mt-3 col-form-label">Apellido</label>
			    {!! Form::text('last_name', $lastNameValue, array(
			    	'placeholder' => 'Apellido',
			    	'class' => 'form-control mt-3 col-sm-8'
			    )) !!}
		  	</div>
		  	<div class="form-group row">
			    <label for="birthdate" class="col-sm-3 mt-3 col-form-label" >Fecha de nacimiento</label>
			    <input type="date" min="2005-01-01" class="form-control mt-3 col-sm-8" id="birthdate" name="birthdate" value="{{ $birthdateValue }}" required>
		  	</div>
		  	<div class="form-group row">
			    <label for="gender" class="col-sm-3 mt-3 col-form-label">Género</label>
		    	@if($genderValue == 'm')
		    		{!! Form::select('gender', array('m' => 'Masculino', 'f' => 'Femenino'), 'm', ['class'=>'form-control mt-3 col-sm-8']) !!}
	      		@else
	      			{!! Form::select('gender', array('m' => 'Masculino', 'f' => 'Femenino'), 'f', ['class'=>'form-control mt-3 col-sm-8']) !!}
      			@endif
		  	</div>
		  	<div class="form-group row">
			    <label for="type_document" class="col-sm-3 mt-3 col-form-label" >Tipo de documento</label>
			    @if($typeDocumentValue == 'a')
		    		{!! Form::select('type_document', array('dni' => 'DNI', 'a' => 'A'), 'a', ['class'=>'form-control mt-3 col-sm-8']) !!}
	      		@else
	      			{!! Form::select('type_document', array('dni' => 'DNI', 'a' => 'A'), 'dni', ['class'=>'form-control mt-3 col-sm-8']) !!}
      			@endif
		  	</div>
		  	<div class="form-group row ">
			    <label for="document_number"  class="col-sm-3 mt-3 col-form-label">Número de documento</label>
			    {!! Form::text('document_number', $documentNumberValue, array(
			    	'placeholder' => 'Número de documento',
			    	'class' => 'form-control mt-3 col-sm-8'
			    )) !!}
			</div>
			<div class="form-group row ">
			    <label for="address2"  class="col-sm-3 mt-3 col-form-label">Dirección2</label>
			    {!! Form::text('address', $addressValue, array(
			    	'placeholder' => 'Dirección',
			    	'class' => 'form-control mt-3 col-sm-8'
			    )) !!}
			</div>
			<div class="form-group row ">
			    <label for="phone"  class="col-sm-3 mt-3 col-form-label">Teléfono</label>
			    {!! Form::text('phone', $phoneValue, array(
			    	'placeholder' => 'Teléfono',
			    	'class' => 'form-control mt-3 col-sm-8'
			    )) !!}
			</div>
			<div class="text-center">
				<button type="submit" class="btn btn-outline-success btn-own-info">Agregar</button>
			</div>
		{!! Form::close() !!}
	</div>
</section>