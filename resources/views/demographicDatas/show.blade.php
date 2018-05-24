@extends('base')
@section('title') 
	Datos demograficos
@stop

@section('container')

<h2 class="text-center" ></h2>
<section class="row mx-auto mt-5 ">
	<div class="login col-md-8  mx-auto mt-4 mb-4 pb-5 pt-5 pr-5 pl-5 border rounded ">
		@if(isset($demographicData))
		<table class="table table-hover">
			<tbody>
   				<tr>
	     			<th scope="row">Heladera</th>
	     			<td>
	     				@if($demographicData->refrigerator == 1)
	     			 		Si
	     			 	@else 
	     			 		No
	     			 	@endif
	     			</td>
    			</tr>
			    <tr>
	     			<th scope="row">Electricidad</th>
	     			<td>
		     			@if($demographicData->electricity == 1)
	     			 		Si
	     			 	@else 
	     			 		No
	     			 	@endif
	     			</td>
			    </tr>
			    <tr>
	     			 <th scope="row">Mascota</th>
	     			 <td>
		     			@if($demographicData->pet == 1)
	     			 		Si
	     			 	@else 
	     			 		No
	     			 	@endif
	     			</td>
			    </tr>
			    <tr>
	     			 <th scope="row">Tipo de vivienda</th>
	     			 <td>{{ $typeLivingPlace->nombre }}</td>
			    </tr>
			    <tr>
	     			 <th scope="row">Tipo de calefacción</th>
	     			 <td>{{ $typeHeating->nombre }}</td>
			    </tr>
	     		<tr>
	     			 <th scope="row">Tipo de agua</th>
	     			 <td>{{ $typeWater->nombre }}</td>
	     		</tr>
 			 </tbody>
		</table>
		@endif
	</div>
</section>
@stop