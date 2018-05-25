@extends('base')
@section('title') 
	Controles
@stop

@section('container')

<h2 class="text-center" ></h2>
<section class="row mx-auto mt-5 ">
	<div class="login col-md-8  mx-auto mt-4 mb-4 pb-5 pt-5 pr-5 pl-5 border rounded ">
		<table class="table table-hover">
			<tbody>
   				 <tr>
	     			 <th scope="row">Fecha</th>
	     			 <td>{{$control->fecha}}</td>
    			</tr>
			    <tr>
	     			 <th scope="row">Edad</th>
	     			 <td>{{$control->edad}}</td>
			    </tr>
			    <tr>
	     			 <th scope="row">Peso</th>
	     			 <td>{{$control->peso}}</td>
			    </tr>
			    <tr>
	     			 <th scope="row">Vacunas completas</th>
	     			 @if($control->vacunasCompletas)
	     			 	<td>Si</td>
	     			 @else
	     			 	<td>No</td>
	     			 @endif
	     			 
			    </tr>
			    <tr>
	     			 <th scope="row">Observaciones vacunas</th>
	     			 <td>{{$control->observacionesVacunas}}</td>
			    </tr>
			    <tr>
	     			 <th scope="row">Maduracion acorde</th>
	     			 {% if $control->maduracionAcorde %}
	     			 	<td>Si</td>
	     			 @else
	     			 	<td>No</td>
	     			 @endif
			    </tr>
			    <tr>
	     			 <th scope="row">Observaciones maduracion</th>
	     			 <td>{{$control->observacionesMaduracion}}</td>
			    </tr>
			    <tr>
	     			 <th scope="row">Examen fisico normal</th>
	     			 {% if $control->examenFisicoNormal %}
	     			 	<td>Si</td>
	     			 @else
	     			 	<td>No</td>
	     			 @endif
			    </tr>
			    <tr>
	     			 <th scope="row">Observaciones examen fisico</th>
	     			 <td>{{$control->observacionesExamen}}</td>
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
	     			 <td>{{$control->talla}}</td>
			    </tr>
			    <tr>
	     			 <th scope="row">Descripción de alimientación</th>
	     			 <td>{{$control->descripcionAlimentacion}}</td>
			    </tr>
			    <tr>
	     			 <th scope="row">Observaciones generales</th>
	     			 <td>{{$control->observacionesGenerales}}</td>
			    </tr>
 			 </tbody>
		</table>
		@php
			$idPaciente = $control->idPaciente;
			$idControl = $control->id;
		@endphp
		<div class="row">
			<div class="text-center col-md-4">
				<a href='{{url("/patient/$idPaciente")}}' class="btn btn-outline-success btn-own-info">Volver al paciente</a>
			</div>
			<div class="text-center  col-md-4">
				<a href="/index.php/paciente/{{idPaciente}}/historiaClinica" class="btn btn-outline-success btn-own-info">Volver a historia clinica</a>
			</div>
			<div class="text-center  col-md-4 ">
				<a href="/index.php/paciente/{{idPaciente}}/control/edicion/{{idControl}}" class="btn btn-outline-success btn-own-info">Editar</a>
			</div>
		</div>
	</div>

</section>