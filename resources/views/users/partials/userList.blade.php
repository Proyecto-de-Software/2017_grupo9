
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
				    <tr>
				    	<td>{{ $user->username }}</td>
				    	<td>
				    		<a href="{{url('/user/$user->id/edit')}}" class="btn btn-outline-success btn-own-info">Editar</a>
				    	</td>
				    	<td>
				    		<a onclick="return confirm('Seguro?')"  href="{{url('/user/$user->id')}}" class="btn btn-outline-success btn-own-info">Eliminar </a>
				    	</td>
			      		<td>
				      		@if($user->activo)
				      			<a href="{{url('user/$user->id/block') }}" class="btn btn-outline-success btn-own-info"> Bloquear </a>
				      		@else
				      			<a href="{{url('user/$user->id/unblock') }}" class="btn btn-outline-success btn-own-info"> Activar </a>
			      			@endif	
				      	</td>
				      	<td>
				      		<a href="/index.php/usuario/{{ $user->id }}" class="btn btn-outline-success btn-own-info">Mas información</a>
				      	</td>
				    </tr>
			     @endforeach
			    
			</tbody>
		</table>
		<a class="btn btn-success btn-own mt-3 mb-5 text-right" role="button" href="{{url('/user/create')}}">
			Agregar nuevo usuario
		</a>
		

</section>
