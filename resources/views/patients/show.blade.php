@extends('base')
@section('title') 
	Detalles de paciente
@stop

@section('container')

<h2 class="text-center" ></h2>
<section class="row mx-auto mt-5 ">
	<div class="login col-md-8  mx-auto mt-4 mb-4 pb-5 pt-5 pr-5 pl-5 border rounded ">
		<table class="table table-hover">
			<tbody>
   				 <tr>
	     			 <th scope="row">Nombre</th>
	     			 <td>{{ $patient->first_name }}</td>
    			</tr>
			    <tr>
	     			 <th scope="row">Apellido</th>
	     			 <td>{{ $patient->last_name }}</td>
			    </tr>
			    <tr>
	     			 <th scope="row">Domicilio</th>
	     			 <td>{{ $patient->address }}</td>
			    </tr>
			    <tr>
	     			 <th scope="row">Teléfono</th>
	     			 <td>{{ $patient->phone }}</td>
			    </tr>
			    <tr>
	     			 <th scope="row">Fecha de nacimiento</th>
	     			 <td>{{ $patient->birthdate }}</td>
			    </tr>
			    <tr>
	     			 <th scope="row">Género</th>
	     			 <td>{{ $patient->gender }}</td>
			    </tr>
			    <tr>
	     			 <th scope="row">Obra social</th>
	     			 @if($healthInsurance == null)
	     			 	<td> No posee obra social </td>
	     			 @else
	     			 	<td>{{ $healthInsurance->nombre }}</td>
			    	@endif
			    </tr>
			    <tr>
	     			 <th scope="row">Tipo de documento</th>
	     			 <td>{{ $typeDocument->nombre }}</td>
			    </tr>
			    <tr>
	     			 <th scope="row">Nro de documento</th>
	     			 <td>{{ $patient->document_number }}</td>
			    </tr>
 			 </tbody>
		</table>
		<div class="text-center row">
			<div class="text-center col-md-4 mx-auto">
				<a href='{{url("/patient")}}' class="col-md-3 mr-3 ml-3 btn btn-outline-success btn-own-info"> Volver a pacientes</a>
			</div>
			<div class="text-center col-md-4 mx-auto">
				<a href='{{url("/patient/$patient->id/edit")}}' class="btn btn-outline-success btn-own-info">Editar</a>
			</div>
			@if($patient->demographic_data_id == null)
				<div class="text-center col-md-4 mx-auto">
					<a href='{{url("/demographicData/create/$patient->id")}}' class="btn btn-outline-success btn-own-info">Agregar datos demográficos</a>
				</div>
			@else
				<div class="text-center col-md-4 mx-auto">
					<a href='{{url("/demographicData/$patient->demographic_data_id")}}' class="btn btn-outline-success btn-own-info">Ver datos demográficos</a>
				</div>
			@endif
			<div class="text-center col-md-4 mx-auto">
				<a href='{{url("/medicalCheckup/patient/$patient->id")}}' class="btn btn-outline-success btn-own-info">Historia clínica</a>
			</div>
		</div>
	</div>

</section>

@stop