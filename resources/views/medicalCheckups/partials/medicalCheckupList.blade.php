@if (session('alert'))
    <div class="alert alert-success">
        {{ session('alert') }}
    </div>
@endif
<section>
	<h2> Historia Clinica</h2><br>
		<div class="mb-4 mt-4">
			<h3 >Controles </h3> 
			<a class="btn btn-success btn-own mt-3 mb-5 text-right" role="button" href='{{url("/medicalCheckup/create/$patient_id")}}'>
			Agregar control </a>
			<a class="btn btn-success btn-own mt-3 mb-5 text-right" role="button" href='{{url("/medicalCheckup/patient/reports/$patient_id")}}'>
			Estadisticas gráficas </a>
			<table class="table table-hover">
			  	<thead>
				    <tr>
				    	<th> Fecha</th>
				    </tr>
			  	</thead>
			  	<tbody>
			  		@foreach($controls as $control)
					    <tr>
					    	<td>{{ $control->date }}</td>
					    	<td>
					    		<a href='{{url("/medicalCheckup/$control->id")}}' class="btn btn-outline-success btn-own-info"> Ver control </a>
					    	</td>
					    	<!-- Aca van los permisos -->
					    	<td>
					    		<td>
					    			{!! Form::open(
										array(
											'route' => ['medicalCheckup.destroy',$control->id],
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
					    	</td>
					    	<!-- Aca van los permisos -->
					    </tr>
				     @endforeach
				</tbody>
			</table>
			{!! $controls->render() !!}
		</div>
</section>