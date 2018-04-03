@extends('base')
@section('title') 
	Detalles de usuario
@stop

@section('container')
<h2 class="text-center" ></h2>
<section class="row mx-auto mt-5 ">
	<div class="login col-md-8  mx-auto mt-4 mb-4 pb-5 pt-5 pr-5 pl-5 border rounded ">
		<table class="table table-hover">
			<tbody>
   				 <tr>
	     			 <th scope="row">Nombre</th>
	     			 <td>{{$user->first_name}}</td>
    			</tr>
			    <tr>
	     			 <th scope="row">Apellido</th>
	     			 <td>{{$user->last_name}}</td>
			    </tr>
			    <tr>
	     			 <th scope="row">Usuario</th>
	     			 <td>{{$user->username}}</td>
			    </tr>
			    <tr>
	     			 <th scope="row">Email</th>
	     			 <td>{{$user->email}}</td>
			    </tr>
			    <tr>
	     			 <th scope="row">Estado</th>
	     			 <td>
	     			 	@if($user->active)
	     			 		<p class="text-success">
	     			 			Activo
	     			 		</p>
						@else
							 <p class="text-danger">
	     			 			Inactivo
	     			 		</p>
	     			 	@endif
	     			 </td>
			    </tr>
			    <tr>
	     			 <th scope="row">Roles: </th>
	     			 <td>
	     			 	@foreach($rols as $rol)
	     			 		{{$rol->name}}
	     			 	@endforeach
	     			 </td>
	     		</tr>
 			 </tbody>
		</table>
		<div class="text-center">
			<a href='{{url("/user/$user->id/edit")}}' class="btn btn-outline-success btn-own-info">Editar</a>
		</div>
	</div>

</section>
@stop