
<section>
	<h2> Usuarios</h2><br>
		<div class="mb-4 mt-4">
			<h3 >Filtrado </h3> 
			<form  id="form" class="form-inline my-2 my-lg-0 ml-auto mr-5 d-flex justify-content-start" action="/index.php/usuarios/filtrado" method="POST">
				<input type="hidden" name="filtrado">		
				@if(isset($filtrado))
	      			<input class="form-control mr-sm-2 " type="text" placeholder="Buscar" aria-label="Buscar" name="buscar" id="buscar" value="{{filtrado.campoBuscar}}">
	      		@else
	      			<input class="form-control mr-sm-2 " type="text" placeholder="Buscar" aria-label="Buscar" name="buscar" id="buscar">
	      		@endif

	      		@if(filtrado->activo) 
					<input type="checkbox" name="activo" id="activo" class="checkbox mr-2 ml-2" value="activo" checked> 
				@else
					<input type="checkbox" name="activo" id="activo" class="checkbox mr-2 ml-2" value="activo">  
				@endif
    			<label for="rol">Activo</label><br/>

    			@if filtrado.bloqueado 
					<input type="checkbox" name="bloqueado" id="bloqueado" class="checkbox mr-2 ml-2" value="bloqueado" checked={{filtrado.bloqueado}}>
				@else
					<input type="checkbox" name="bloqueado" id="bloqueado" class="checkbox mr-2 ml-2" value="bloqueado">
				@endif
    			<label for="rol">Bloqueado</label><br/>
	      		<button class="btn btn-success btn-search btn-own  my-2 my-sm-0 mr-2 ml-2" type="submit">Filtrar</button>
		    </form>
		</div>
		<table class="table table-hover">
		  	<thead>
			    <tr>
			    	<th>Nombre de usuario</th>
			    	<th colspan="4">
			    </tr>
		  	</thead>
		  	<tbody>
			  	@foreach($users as $user)
				    <tr id="{{ $user->id }}" >
				    	<td>{{ $user->username }}</td>
				    	<td>
				    		<a href='{{url("/user/$user->id/edit")}}' class="btn btn-outline-success btn-own-info">Editar</a>
				    	</td>
				    	<td>
				    		{!! Form::open(
									array(
										'route' => ['user.destroy',$user->id],
										'method' => 'DELETE',
										'class' => 'eliminar',
										'id' => "$user->id"),
										
									array(
										'role' => 'form')
									)
								!!}
									{!! Form::button('Eliminar', array(
											'type' => 'submit',
									 		'class' => 'btn btn-outline-success btn-own-info eliminar'
									 )) 
									!!} 
								{!! Form::close() !!}
				    	</td>
			      		<td>

				      		@if($user->active)
					      		@php
				      				$route = 'user.block';
				      				$buttonName = 'Bloquear';
				      			@endphp
				      		@else
				      			@php
				      				$route = 'user.unblock';
				      				$buttonName = 'Activar';
				      			@endphp
				      		@endif
								{!! Form::open(
									array('route' => [$route,$user->id], 'method' => 'POST'), 
									array('role' => 'form')
									)
								!!}
									{!! Form::button($buttonName, array(
											'type' => 'submit',
									 		'class' => 'btn btn-outline-success btn-own-info'
									 )) 
									!!} 
								{!! Form::close() !!}

				      	</td>
				      	<td>
				      		<a href='{{url("user/$user->id") }}' class="btn btn-outline-success btn-own-info">Mas información</a>
				      	</td>
				    </tr>
			     @endforeach
			    
			</tbody>
		</table>

			{!! $users->render() !!}

		<a class="btn btn-success btn-own mt-3 mb-5 text-right" role="button" href="{{url('/user/create')}}">
			Agregar nuevo usuario
		</a>
		

</section>
