@if (session('alert'))
    <div class="alert alert-success">
        {{ session('alert') }}
    </div>
@endif
<section>
	<h2> Pacientes </h2><br>
		<div class="mb-4 mt-4">
			{!! Form::open(['route' => 'patient.index', 'method' => 'GET', 'class' => 'navbar-form navbar-left d-flex span4', 'role' => 'search']) !!}
				<div class="form-group row">
					{!! Form::text('name', null, ['class' => 'form-control ml-auto', 'placeholder' => 'Ingrese nombre']) !!}
				</div>
				<button type="submit" class="btn btn-outline-success btn-own-info"> Buscar </button>
			{!! Form::close() !!}
			{!! Form::open(['route' => 'patient.index', 'method' => 'GET', 'class' => 'navbar-form navbar-left d-flex span8', 'role' => 'search']) !!}
				<div class="form-group row">
					<select class="form-control mt-3 col-sm-8" name="type_document">
						@foreach($typesDocument as $value)
							@if($typeDocument == $value->id)
								<option value="{{ $value->id }}" selected>{{ $value->nombre }}</option>
							@else
								<option value="{{ $value->id }}">{{ $value->nombre }}</option>
							@endif
						@endforeach
					</select>
					{!! Form::input('number', 'document_number', null, ['class' => 'form-control ml-auto', 'placeholder' => 'Ingrese número de documento']) !!}
				</div>
				<button type="submit" class="btn btn-outline-success btn-own-info"> Buscar </button>
			{!! Form::close() !!}
		</div>
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
				    	@if(Auth::user()->can('patient_update'))
					    	<td>
					    		<a href='{{url("/patient/$patient->id/edit")}}' class="btn btn-outline-success btn-own-info">Editar</a>
					    	</td>
				    	@endif
				    	@if(Auth::user()->can('patient_destroy'))
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
								{!! Form::button('Eliminar', 
									array(
										'type' => 'submit',
								 		'class' => 'btn btn-outline-success btn-own-info'
								 )) 
								!!} 
								{!! Form::close() !!}
				    		</td>
			    		@endif
			    		@if(Auth::user()->can('patient_show'))
					      	<td>
					      		<a href='{{url("patient/$patient->id")}}' class="btn btn-outline-success btn-own-info">Mas información</a>
					      	</td>
					    @endif
				    </tr>
			     @endforeach
			    
			</tbody>
		</table>
		{!! $patients->render() !!}
		<a class="btn btn-success btn-own mt-3 mb-5 text-right" role="button" href="{{url('/patient/create')}}">
			Agregar nuevo paciente
		</a>
		
</section>
