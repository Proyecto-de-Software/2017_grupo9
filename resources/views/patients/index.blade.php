@extends('base')
@section('title') 
	Administracion pacientes
@stop

@section('container')
	@include('patients.partials.patientList')
@stop