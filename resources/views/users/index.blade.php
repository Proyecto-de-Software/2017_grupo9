@extends('base')
@section('title') 
	Administracion usuarios
@stop

@section('container')
	@include('users.partials.userList')
	
@stop