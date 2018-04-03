
<section>
	<h2> Usuarios</h2><br>
		<div class="mb-4 mt-4">
	
		</div>
		<table class="table table-hover">
		  	<thead>
			    <tr>
			      	<th>Nombre</th>
			     	<th>Apellido</th>
			      	<th>DNI</th>
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
				    		<a href="{{url('/patient/$patient->id/edit')}}" class="btn btn-outline-success btn-own-info">Editar</a>
				    	</td>
				    	<td>
				    		<form action="{{url('/patient/$patient->id')}}" method="post">
							    <input type="hidden" name="_method" value="delete" />
							</form>
						</td>
				      	<td>
				      		<a href="/index.php/patient/{{ $patient->id }}" class="btn btn-outline-success btn-own-info">Mas información</a>
				      	</td>
				    </tr>
			     @endforeach
			    
			</tbody>
		</table>
		<a class="btn btn-success btn-own mt-3 mb-5 text-right" role="button" href="/index.php/patient/create">
			Agregar nuevo paciente
		</a>
		

</section>
