@extends('base')
@section('title') 
	Detalles de paciente
@stop

@section('container')

<section class="row mx-auto mt-5 ">
	<div class="login col-md-6  mx-auto mt-4 mb-4 pb-5 pt-5 pr-5 pl-5 border rounded ">



		@if(isset($configuration))
			@php
				$title = 'Editar configuración';
				$url = '/configuration/'.$configuration->id;
				$method = 'put';
				$titleValue = $configuration->title;
				$emailContactValue = $configuration->email_contact;
				$elementsForPageValue = $configuration->elements_for_page;
				$stateValue = $configuration->state;
				$hospitalDescriptionValue = $configuration->hospital_description;
				$guardDescriptionValue = $configuration->guard_description;
				$specialtiesDescriptionValue = $configuration->specialties_description;
			@endphp
		@else
			@php
				$title = 'Agregar configuración';
				$url = '/configuration';
				$method = 'post';
				$titleValue = null;
				$emailContactValue = null;
				$elementsForPageValue = null;
				$stateValue = 1;
				$hospitalDescriptionValue = null;
				$guardDescriptionValue = null;
				$specialtiesDescriptionValue = null;
			@endphp
		@endif
		<h3 class="card-header text-center myHeader mb-4"> {{ $title }} </h3>

		{!! Form::open(['url' => $url, 'method' => $method]) !!} 

			<div class="form-group row ">
			    {!! Form::label('title', 'Titulo',[
					    'class'=>'col-sm-3 mt-3 col-form-label'
					    ]) 
			    !!}
			    {!! Form::text('title', $titleValue, [
			    	'placeholder' => 'Titulo',
			    	'class' => 'form-control mt-3 col-sm-8'
			    ]) !!}
			</div>

			<div class="form-group row ">
			    {!! Form::label('email_contact', 'Email',[
					    'class'=>'col-sm-3 mt-3 col-form-label'
					    ]) 
			    !!}
			    {!! Form::text('email_contact', $emailContactValue, [
			    	'placeholder' => 'Email',
			    	'class' => 'form-control mt-3 col-sm-8'
			    ]) !!}
			</div>

			<div class="form-group row ">
			    {!! Form::label('elements_for_page', 'Elementos por pagina',[
					    'class'=>'col-sm-3 mt-3 col-form-label'
					    ]) 
			    !!}
			    {!! Form::text('elements_for_page', $elementsForPageValue, [
			    	'placeholder' => 'Elementos por pagina',
			    	'class' => 'form-control mt-3 col-sm-8'
			    ]) !!}
			</div>

			<div class="form-group row ">
				{!! Form::label('state', 'Estado',[
					    'class'=>'col-sm-3 mt-3 col-form-label'
					    ]) 
			    !!}
				@if($stateValue = 'enabled')
					{!! Form::label('state', 'Página habilitada',[
						    'class'=>'col-sm-3 mt-3 col-form-label'
						    ]) 
				    !!}
					{!! Form::checkbox('state', 'enabled', true, array(
								 	'class' => 'checkbox col-sm-0 '
								 	)) 
				 	!!}	
				@else
					{!! Form::label('state', 'Página habilitada',[
						    'class'=>'col-sm-3 mt-3 col-form-label'
						    ]) 
				    !!}
				    {!! Form::checkbox('state', 'disabled', false, array(
								 	'class' => 'checkbox col-sm-0 '
								 	)) 
				 	!!}	
				@endif
			</div>

			<div class="form-group row ">
			    {!! Form::label('hospital_description', 'Descripcion del hospital',[
					    'class'=>'col-sm-3 mt-3 col-form-label'
					    ]) 
			    !!}
			    {!! Form::text('hospital_description', $hospitalDescriptionValue, [
			    	'placeholder' => 'Descripcion del hospital',
			    	'class' => 'form-control mt-3 col-sm-8'
			    ]) !!}
			</div>

			<div class="form-group row ">
			    {!! Form::label('guard_description', 'Descripcion de la guardia',[
					    'class'=>'col-sm-3 mt-3 col-form-label'
					    ]) 
			    !!}
			    {!! Form::text('guard_description', $guardDescriptionValue, [
			    	'placeholder' => 'Descripcion de la guardia',
			    	'class' => 'form-control mt-3 col-sm-8'
			    ]) !!}
			</div>

			<div class="form-group row ">
			    {!! Form::label('specialties_description', 'Descripcion de especialidades',[
					    'class'=>'col-sm-3 mt-3 col-form-label'
					    ]) 
			    !!}
			    {!! Form::text('specialties_description', $specialtiesDescriptionValue, [
			    	'placeholder' => 'Descripcion de especialidades',
			    	'class' => 'form-control mt-3 col-sm-8'
			    ]) !!}
			</div>

			<button type="submit" name="button" class="btn btn-outline-success  btn-own-info">Guardar</button>

		{!! Form::close() !!}
	</div>
</section>
@stop