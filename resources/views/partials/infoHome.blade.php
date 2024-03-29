<section class="row d-flex align-items-top">
	<h2 hidden>Hospital Gutierrez</h2>			
	<article class="col-md-3 mb-4 pb-2 mx-auto text-center infoPrincipal">
		<h3 class="card-header myHeader">EL HOSPITAL</h3>
		<p class="mt-2 ml-3 mr-3">
			{{$config->hospital_description}}
		</p>
		<a class="btn btn-outline-success btn-own-info" role="button" href="#">Mas información...</a>
	</article>
	<article class="col-md-3 mb-4 mx-auto pb-2 text-center infoPrincipal"> 			
		<h3 class="card-header myHeader">GUARDIA </h3>
		<p class="mt-2 ml-3 mr-3">
			{{$config->guard_description}}
		</p>
		<a class="btn btn-outline-success btn-own-info " role="button" href="#">Mas información...</a>
	</article>
	<article class="col-md-3 mb-4 mx-auto text-center pb-2 infoPrincipal">
		<h3 class="card-header myHeader">ESPECIALIDADES </h3>
		<p class="mt-2 ml-3 mr-3">
			{{$config->specialties_description}}
		</p>					
		<a class="btn btn-outline-success btn-own-info " role="button" href="#">Mas información...</a>
	</article>			
</section>