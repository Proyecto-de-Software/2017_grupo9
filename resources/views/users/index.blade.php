@extends(base)
@section('title') 
	Administracion usuarios
@stop

@section('container')
	@include('user.partials.userList')
	@include('partials.paged')
@stop