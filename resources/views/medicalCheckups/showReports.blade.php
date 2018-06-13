@extends('base')
@section('title') 
	Reportes
@stop

@section('container')
	@if($gender == 'masculino')
		@include('medicalCheckups.partials.reportsMale')
	@else
		@include('medicalCheckups.partials.reportsFemale')
	@endif
	
@stop