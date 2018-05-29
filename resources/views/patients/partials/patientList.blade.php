<section>
	<h2> Pacientes </h2><br>
		<div class="mb-4 mt-4">
	
		</div>
		{!! Form::open(['route' => 'patient.index', 'method' => 'GET', 'class' => 'navbar-form navbar-left d-flex', 'role' => 'search']) !!}
			<div class="form-group">
				{!! Form::text('name', null, ['class' => 'form-control ml-auto']) !!}
			</div>
			<button type="submit" class="btn btn-outline-success btn-own-info"> Buscar </button>
		{!! Form::close() !!}
		<form class="navbar-form navbar-left d-flex" role="search">
			<div class="form-group">
				<input type="text" class="form-control ml-auto" name="">
			</div>
			<button type="submit" class="btn btn-outline-success btn-own-info"> Buscar </button>
		</form>
		<table class="table table-hover table-scripted">
		  	<thead>
			    <tr>
			      	<th>Nombre</th>
			     	<th>Apellido</th>
			      	<th>DNI</th>
			     	<th></th>
			     	<th></th>
			     	<th></th>
			    </tr>
			</thead>
		  	<tbody>
			  	@foreach($patients as $patient)
				    <tr>
				    	<td>{{ $patient->first_name }}</td>
				    	<td>{{ $patient->last_name }}</td>
				    	<td>{{ $patient->document_number }}</td>
				    	<td>
				    		<a href='{{url("/patient/$patient->id/edit")}}' class="btn btn-outline-success btn-own-info">Editar</a>
				    	</td>
				    	<td>
				    		{!! Form::open(
									array(
										'route' => ['patient.destroy',$patient->id],
										'method' => 'DELETE',
										'onsubmit' => 'return confirm("Seguro?")'), 
									array(
										'role' => 'form')
									)
								!!}
									{!! Form::button('Eliminar', array(
											'type' => 'submit',
									 		'class' => 'btn btn-outline-success btn-own-info'
									 )) 
									!!} 
								{!! Form::close() !!}
				    	</td>
				      	<td>
				      		<a href='{{url("patient/$patient->id")}}' class="btn btn-outline-success btn-own-info">Mas información</a>
				      	</td>
				    </tr>
			     @endforeach
			    
			</tbody>
		</table>
		{!! $patients->links() !!}
		<a class="btn btn-success btn-own mt-3 mb-5 text-right" role="button" href="{{url('/patient/create')}}">
			Agregar nuevo paciente
		</a>
		
</section>
