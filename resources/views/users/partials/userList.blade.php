
<section>
	<h2> Usuarios</h2><br>
		<div class="mb-4 mt-4">
			<h3 >Filtrado </h3> 
			{!! Form::open(['route' => 'user.index', 'method' => 'GET', 'class' => 'navbar-form navbar-left d-flex span4', 'role' => 'search']) !!}
				<input type="hidden" name="filtrado">		
				@if($username != '')
					{!! Form::text('username', $username, ['class' => 'form-control mr-sm-2', 'placeholder' => 'Nombre de usuario']) !!}
	      		@else
	      			{!! Form::text('username', null, ['class' => 'form-control mr-sm-2', 'placeholder' => 'Nombre de usuario']) !!}
	      		@endif

	      		@if($active == 1)
					{!! Form::checkbox('active', 1, true, array(
								 	'class' => 'checkbox mr-2 ml-2 '
								 	)) 
				 	!!}
				 	{!! Form::label('active', 'see',[
						    'for' => 'rol'
						    ]) 
				    !!}
				@else
				    {!! Form::checkbox('active', 1, false, array(
								 	'class' => 'checkbox mr-2 ml-2'
								 	)) 
				 	!!}	
					{!! Form::label('active', 'Activo',[
						    'for' => 'rol'
						    ]) 
				    !!}
				@endif
	      		<button class="btn btn-success btn-search btn-own  my-2 my-sm-0 mr-2 ml-2" type="submit">Filtrar</button>
		    {!! Form::close() !!}
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
