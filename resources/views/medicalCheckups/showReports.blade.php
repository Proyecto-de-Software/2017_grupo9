@extends('base')
@section('title') 
	Reportes
@stop

@section('container')
	@if(genero == 'masculino')
		@include('medicalCheckups.partials.reportsMale')
	@else
		@include('medicalCheckups.partials.reportsFemale')
	@endif
	
@stop