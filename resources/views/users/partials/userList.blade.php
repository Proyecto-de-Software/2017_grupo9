
<section>
	<h2> Usuarios</h2><br>
		<div class="mb-4 mt-4">
	
		</div>
		<table class="table table-hover">
		  	<thead>
			    <tr>
			    	<th>Nombre de usuario</th>

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
		{!! $patients->render() !!}
		<a class="btn btn-success btn-own mt-3 mb-5 text-right" role="button" href="{{url('/user/create')}}">
			Agregar nuevo usuario
		</a>
		

</section>
