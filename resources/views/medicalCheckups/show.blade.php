@extends('base')
@section('title') 
	Control
@stop

@section('container')

<h2 class="text-center" ></h2>
<section class="row mx-auto mt-5 ">
	<div class="login col-md-8  mx-auto mt-4 mb-4 pb-5 pt-5 pr-5 pl-5 border rounded ">
		<table class="table table-hover">
			<tbody>
   				 <tr>
	     			 <th scope="row">Fecha</th>
	     			 <td>{{$control->date}}</td>
    			</tr>
			    <tr>
	     			 <th scope="row">Edad</th>
	     			 <td>{{$control->edad}}</td>
			    </tr>
			    <tr>
	     			 <th scope="row">Peso</th>
	     			 <td>{{$control->weight}}</td>
			    </tr>
			    <tr>
	     			 <th scope="row">Vacunas completas</th>
	     			 @if($control->complete_vaccines == 1)
	     			 	<td>Si</td>
	     			 @else
	     			 	<td>No</td>
	     			 @endif
			    </tr>
			    <tr>
	     			 <th scope="row">Observaciones vacunas</th>
	     			 <td>{{$control->complete_vaccines_observation}}</td>
			    </tr>
			    <tr>
	     			 <th scope="row">Maduracion acorde</th>
	     			 @if($control->correct_maturation == 1)
	     			 	<td>Si</td>
	     			 @else
	     			 	<td>No</td>
	     			 @endif
			    </tr>
			    <tr>
	     			 <th scope="row">Observaciones maduracion</th>
	     			 <td>{{$control->correct_maturation_observation}}</td>
			    </tr>
			    <tr>
	     			 <th scope="row">Examen fisico normal</th>
	     			 @if($control->normal_physical_examination == 1)
	     			 	<td>Si</td>
	     			 @else
	     			 	<td>No</td>
	     			 @endif
			    </tr>
			    <tr>
	     			 <th scope="row">Observaciones examen fisico</th>
	     			 <td>{{$control->normal_physical_examination_observation}}</td>
			    </tr>
			    <tr>
	     			 <th scope="row">Percentilo cefálico</th>
	     			 <td>{{$control->pc}}</td>
			    </tr>
			    <tr>
	     			 <th scope="row">Percentilo perímetro cefálico</th>
	     			 <td>{{$control->ppc}}</td>
			    </tr>
			     <tr>
	     			 <th scope="row">Talla</th>
	     			 <td>{{$control->height}}</td>
			    </tr>
			    <tr>
	     			 <th scope="row">Descripción de alimientación</th>
	     			 <td>{{$control->food_description}}</td>
			    </tr>
			    <tr>
	     			 <th scope="row">Observaciones generales</th>
	     			 <td>{{$control->general_observation}}</td>
			    </tr>
 			 </tbody>
		</table>
		<div class="row">
			<div class="text-center col-md-4">
				<a href='{{url("/patient/$control->patient_id")}}' class="btn btn-outline-success btn-own-info">Volver al paciente</a>
			</div>
			<div class="text-center  col-md-4">
				<a href='{{url("/medicalCheckup/patient/$control->patient_id")}}' class="btn btn-outline-success btn-own-info">Volver a historia clinica</a>
			</div>
			<div class="text-center  col-md-4 ">
				<a href='{{url("/medicalCheckup/$control->id/edit")}}' class="btn btn-outline-success btn-own-info">Editar</a>
			</div>
		</div>
	</div>
</section>
@stop