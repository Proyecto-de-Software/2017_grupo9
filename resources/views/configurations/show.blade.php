@extends('base')
@section('title') 
	Configuracion
@stop

@section('container')
	<section class="row mx-auto mt-5 ">
	<div class="login col-md-8  mx-auto mt-4 mb-4 pb-5 pt-5 pr-5 pl-5 border rounded ">
		<h3 class="card-header text-center myHeader mb-4"> Configuracion</h3>
		@php
			$state = config('hospital.state');
		@endphp
		{!! Form::open(['url' => "/config/$config->id", 'method' => 'POST']) !!} 

			<div class="form-group row ">
			    {!! Form::label('title', 'Titulo',[
					    'class'=>'col-sm-3 mt-3 col-form-label'
					    ]) 
			    !!}
			    {!! Form::text('title', $config->title, [
			    	'placeholder' => 'Titulo',
			    	'class' => 'form-control mt-3 col-sm-8'
			    ]) !!}
			</div>

			<div class="form-group row ">
			    {!! Form::label('email_contact', 'Email',[
					    'class'=>'col-sm-3 mt-3 col-form-label'
					    ]) 
			    !!}
			    {!! Form::text('email_contact', $config->email_contact, [
			    	'placeholder' => 'Email',
			    	'class' => 'form-control mt-3 col-sm-8'
			    ]) !!}
			</div>

			<div class="form-group row ">
			    {!! Form::label('elements_for_page', 'Elementos por pagina',[
					    'class'=>'col-sm-3 mt-3 col-form-label'
					    ]) 
			    !!}
			    {!! Form::input('number', 'elements_for_page',  $config->elements_for_page, [
			    	'class' => 'form-control mt-3 col-md-1'
			    ]) !!}
			</div>

			<div class="form-group row ">

					{!! Form::label('state', 'Página habilitada',[
						    'class'=>'col-sm-3 col-form-label'
						    ]) 
				    !!}
					{!! Form::select('state', array('enabled' => 'Habilitado', 'disabled' => 'Deshabilitado'),  $config->state);
					!!}	
				
			</div>

			<div class="form-group row ">
			    {!! Form::label('hospital_description', 'Descripcion del hospital',[
					    'class'=>'col-sm-3 mt-3 col-form-label'
					    ]) 
			    !!}
			    {!! Form::textarea('hospital_description',  $config->hospital_description, [
			    	'placeholder' => 'Descripcion del hospital',
			    	'class' => 'form-control mt-3 col-sm-8'
			    ]) !!}
			</div>

			<div class="form-group row ">
			    {!! Form::label('guard_description', 'Descripcion de la guardia',[
					    'class'=>'col-sm-3 mt-3 col-form-label'
					    ]) 
			    !!}
			    {!! Form::textarea('guard_description',  $config->guard_description, [
			    	'placeholder' => 'Descripcion de la guardia',
			    	'class' => 'form-control mt-3 col-sm-8'
			    ]) !!}
			</div>

			<div class="form-group row ">
			    {!! Form::label('specialties_description', 'Descripcion de especialidades',[
					    'class'=>'col-sm-3 mt-3 col-form-label'
					    ]) 
			    !!}
			    {!! Form::textarea('specialties_description',  $config->specialties_description, [
			    	'placeholder' => 'Descripcion de especialidades',
			    	'class' => 'form-control mt-3 col-sm-8'
			    ]) !!}
			</div>
			<div class="row justify-content-center">
				<button type="submit" name="button" class="btn btn-outline-success col-md-2 btn-own-info">Guardar</button>
			</div>
		{!! Form::close() !!}
	</div>
</section>
	
@stop